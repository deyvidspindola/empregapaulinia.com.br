<?php

use App\Services\Admin\SettingService;

if (! function_exists('setting')) {
    /**
     * Obtém uma configuração persistida (com cache),
     * ex.: setting('home_min_cards', 8)
     */
    function setting(string $key, $default = null) {
        return app(SettingService::class)->get($key, $default);
    }
}

if (! function_exists('settings')) {
    /**
     * Retorna todas as configurações em array (já cacheadas).
     */
    function settings(): array {
        return app(SettingService::class)->all();
    }
}

/**
 * Lê uma configuração “global” de ads.
 * Primeiro tenta pela SettingService (se existir), senão cai no config('ads.*').
 *
 * Chaves esperadas:
 * - network            => ads.network
 * - adsense.client     => ads.adsense.client
 * - gam.path_prefix    => ads.gam.path_prefix
 */
// if (! function_exists('ads_setting')) {
//     function ads_setting(string $key, mixed $default = null): mixed
//     {
//         // Tenta via SettingService (opcional no seu projeto)
//         foreach ([SettingService::class] as $svc) {
//             if (app()->bound($svc)) {
//                 try {
//                     // tenta as três formas mais comuns:
//                     foreach (["ads.$key", $key, str_replace('.', '_', "ads_$key")] as $cand) {
//                         $v = app(abstract: $svc)->get($cand, null);
//                         if (!is_null($v)) return $v;
//                     }
//                 } catch (\Throwable $e) {}
//             }
//         }

//         // Fallback: config/ads.php
//         $map = [
//             'network'         => fn() => config('ads.network', $default),
//             'adsense.client'  => fn() => config('ads.adsense.client', $default),
//             'gam.path_prefix' => fn() => config('ads.gam.path_prefix', $default),
//         ];
        
//         return isset($map[$key]) ? $map[$key]() : $default;
//     }
// }

/**
 * Busca as configurações de um slot pelo “key” (sua tabela ad_slots).
 * - Usa a sua App\Services\Admin\AdSlotService::findByKey()
 * - Fallback direto no DB se a service não estiver bindada
 * Retorna SEMPRE array normalizado do JSON “net_config”, mesclando “sizes” da coluna se existir.
 *
 * Estrutura esperada no JSON do slot (exemplo):
 * {
 *   "network": "adsense",
 *   "adsense": { "slot": "7927456129", "format": "auto", "min_height": "50px" },
 *   "gam": { "unit_path": "/1234567/emprega/sticky-footer", "sizes": [[300,250],[336,280]] }
 * }
 */
// if (! function_exists('ads_slot')) {
//     function ads_slot(string $key): array
//     {
//         $row = null;

//         // 1) via service
//         if (app()->bound(\App\Services\Admin\AdSlotService::class)) {
//             try {
//                 $row = app(\App\Services\Admin\AdSlotService::class)->findByKey($key);
//             } catch (\Throwable $e) {}
//         }

//         // 2) fallback direto
//         if (!$row) {
//             $row = DB::table('ad_slots')->where('key', $key)->first();
//         }
//         if (!$row) return [];

//         // net_config -> array
//         $cfg = $row->net_config ?? null;
//         $cfgArr = is_string($cfg) ? json_decode($cfg, true) : (array) $cfg;
//         if (!is_array($cfgArr)) $cfgArr = [];

//         // sizes da coluna (se existir) complementa o JSON
//         $sizesCol = $row->sizes ?? null;
//         $sizesArr = is_string($sizesCol) ? json_decode($sizesCol, true) : (array) $sizesCol;
//         if ($sizesArr && !isset($cfgArr['gam']['sizes'])) {
//             $cfgArr['gam']['sizes'] = $sizesArr;
//         }

//         // adiciona is_active pra lógica do componente
//         if (isset($row->is_active)) {
//             $cfgArr['is_active'] = (bool) $row->is_active;
//         }

//         return $cfgArr;
//     }
// }