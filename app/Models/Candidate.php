<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    
    protected $fillable = [
        'user_id',
        'full_name',
        'cpf',
        'birth_date',
        'gender',
        'phone',
        'zip',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'logo_path',
        'resume_path',
        'headline',
        'about',
        'skills',
        'social',
        'hourly_rate_cents',
    ];

    protected $appends = [
        'logo_url',
        'resume_url',
        'cpf_formatted',
        'phone_formatted',
        'zip_formatted',
        'birth_date_br',
    ];

public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Mutators (normalizam para apenas dígitos ao salvar) */
    protected function cpf(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? preg_replace('/\D+/', '', (string) $value) : null
        );
    }

    protected function zip(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? preg_replace('/\D+/', '', (string) $value) : null
        );
    }

    protected function birthDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null,
            set: fn ($value) => $value ? \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? preg_replace('/\D+/', '', (string) $value) : null
        );
    }

    /** Accessors (campos derivados/formatados) */
    protected function logoUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
                return Storage::url($this->logo_path);
            }
            return asset('images/user-avatar-placeholder.png');
        });
    }

    protected function resumeUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->resume_path && Storage::disk('public')->exists($this->resume_path)) {
                return Storage::url($this->resume_path);
            }
            return null;
        });
    }

    protected function cpfFormatted(): Attribute
    {
        return Attribute::get(function () {
            $v = $this->cpf;
            if (!$v || strlen($v) !== 11) return $v;
            return substr($v, 0, 3).'.'.substr($v, 3, 3).'.'.substr($v, 6, 3).'-'.substr($v, 9, 2);
        });
    }

    protected function phoneFormatted(): Attribute
    {
        return Attribute::get(function () {
            $p = preg_replace('/\D+/', '', (string) $this->phone);
            if (!$p) return null;

            if (strlen($p) === 11) {
                return sprintf('(%s) %s-%s', substr($p,0,2), substr($p,2,5), substr($p,7,4));
            }
            if (strlen($p) === 10) {
                return sprintf('(%s) %s-%s', substr($p,0,2), substr($p,2,4), substr($p,6,4));
            }
            return $this->phone;
        });
    }

    protected function zipFormatted(): Attribute
    {
        return Attribute::get(function () {
            $z = preg_replace('/\D+/', '', (string) $this->attributes['zip'] ?? '');
            if (strlen($z) === 8) {
                return substr($z, 0, 5) . '-' . substr($z, 5, 3);
            }
            return $z;
        });
    }

}
