<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosting extends Model
{

    protected $fillable = [
        'user_id',
        'company_id',
        'category_id',
        'title',
        'slug',
        'job_type',
        'location',
        'salary',
        'deadline',
        'openings',
        'description',
        'requirements',
        'benefits',
        'observation',
        'is_published',
        'is_company_visible',
        'apply_method',
        'apply_email',
    ];

    protected $casts = [
        'deadline' => 'date',
        'salary' => 'decimal:2',
        'is_published' => 'boolean',
        'is_company_visible' => 'boolean',
    ];

    // ========================================
    // Relationships
    // ========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    // ========================================
    // Scopes
    // ========================================

    public function scopeActive($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', now()->toDateString());
            });
    }

    public function scopeDrafts($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeExpired($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now()->toDateString());
    }

    // ========================================
    // Public Methods
    // ========================================

    public function isDraft(): bool
    {
        return !$this->is_published;
    }

    public function isExpired(): bool
    {
        return $this->is_published 
            && $this->deadline !== null 
            && $this->deadline->isPast();
    }

    public function isActive(): bool
    {
        return $this->is_published && !$this->isExpired();
    }

    // ========================================
    // Accessors & Mutators
    // ========================================

    protected function deadline(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value) : null,
            set: function ($value) {
                if (!$value) {
                    return null;
                }
                
                // Se já é uma instância de Carbon, retorna no formato Y-m-d
                if ($value instanceof \Carbon\Carbon) {
                    return $value->format('Y-m-d');
                }
                
                // Se está no formato brasileiro (dd/mm/yyyy), converte
                if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $value, $matches)) {
                    return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
                }
                
                // Para outros formatos, deixa o Carbon tentar fazer o parse
                try {
                    return \Carbon\Carbon::parse($value)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }
        );
    }

    protected function salary(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value !== null ? number_format($value, 2, ',', '.') : null,
            set: function ($value) {
                if ($value === null || $value === '') {
                    return null;
                }
                
                // Remove pontos de milhar e substitui vírgula por ponto
                $normalized = str_replace(['.', ','], ['', '.'], $value);
                
                // Garante que seja numérico e dentro do limite
                $numeric = floatval($normalized);
                
                // Limita ao máximo permitido pelo decimal(12,2): 9.999.999.999,99
                if ($numeric > 9999999999.99) {
                    $numeric = 9999999999.99;
                }
                
                return $numeric;
            }
        );
    }

    protected function postedOnLabel(): Attribute
    {
        return Attribute::get(
            fn() => $this->created_at 
                ? $this->formatDateLocalized($this->created_at) 
                : null
        );
    }

    protected function updatedOnLabel(): Attribute
    {
        return Attribute::get(
            fn() => $this->updated_at 
                ? $this->formatDateLocalized($this->updated_at) 
                : null
        );
    }

    protected function deadlineLabel(): Attribute
    {
        return Attribute::get(
            fn() => $this->deadline 
                ? $this->formatDateLocalized($this->deadline) 
                : null
        );
    }

    protected function deadlineFormatted(): Attribute
    {
        return Attribute::get(
            fn() => $this->deadline 
                ? $this->deadline->format('d/m/Y') 
                : null
        );
    }

    protected function salaryFormatted(): Attribute
    {
        return Attribute::get(
            fn() => $this->salary 
                ? number_format($this->salary, 2, ',', '.') 
                : null
        );
    }

    protected function deadlinePrefix(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->deadline) {
                return null;
            }
            return $this->deadline->isPast() ? 'Expirado em' : 'Expira em';
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            if ($this->isDraft()) {
                return 'Rascunho';
            }
            if ($this->isExpired()) {
                return 'Expirado';
            }
            return 'Publicado';
        });
    }

    protected function statusColor(): Attribute
    {
        return Attribute::get(
            fn() => match ($this->status_label) {
                'Rascunho' => 'gray',
                'Expirado' => 'red',
                default => 'green',
            }
        );
    }

    protected function postedAt(): Attribute
    {
        return Attribute::get(
            fn() => $this->created_at 
                ? $this->created_at->locale('pt_BR')->diffForHumans() 
                : ''
        );
    }    

    protected function expiredAt(): Attribute
    {
        return Attribute::get(
            fn() => $this->deadline 
                ? $this->deadline->locale('pt_BR')->diffForHumans() 
                : ''
        );
    }


    // ========================================
    // Private Methods
    // ========================================

    /**
     * Formata uma data com locale pt_BR
     * Retorna formato: "10 julho, 2019"
     */
    private function formatDateLocalized(CarbonInterface $date): string
    {
        try {
            return $date->copy()
                ->locale('pt_BR')
                ->isoFormat('D MMMM, YYYY');
        } catch (\Throwable) {
            // Fallback caso intl não esteja disponível
            return $date->format('j F, Y');
        }
    }
}
