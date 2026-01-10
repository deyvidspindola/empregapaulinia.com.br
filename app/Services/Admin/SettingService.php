<?php
namespace App\Services\Admin;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
protected string $cacheKey = 'settings.all';

    public function all(): array
    {
        return Cache::remember($this->cacheKey, 600, function () {
            return Setting::query()->get()
                ->mapWithKeys(fn($s) => [$s->key => $s->value])
                ->toArray();
        });
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    public function get(string $key, $default = null)
    {
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    // public function set(string $key, $value, string $type = 'string'): void
    // {
    //     $this->repository->set($key, $value, $type);
    //     $this->forgetCache();
    // }

    // Conveniências tipadas
    public function initialCredits(): int
    {
        return (int) ($this->get('initial_credits') ?? config('settings.initial_credits', 30));
    }

    public function highlightCosts(): array
    {
        return (array) ($this->get('highlight_costs') ?? config('settings.highlight_costs', [7=>10,15=>18,30=>32]));
    }

    public function highlightCostForDays(int $days): int
    {
        $map = $this->highlightCosts();
        return (int) ($map[$days] ?? $map[ config('settings.default_highlight_days', 7) ] ?? 0);
    }

    public function defaultHighlightDays(): int
    {
        return (int) ($this->get('default_highlight_days') ?? config('settings.default_highlight_days', 7));
    }

    public function homeMinCards(): int
    {
        return (int) ($this->get('home_min_cards') ?? config('settings.home.min_cards', 8));
    }

    public function homeFillRandom(): bool
    {
        $v = $this->get('home_fill_random');
        return is_null($v) ? (bool) config('settings.home.fill_random', true) : (bool) $v;
    }   
}