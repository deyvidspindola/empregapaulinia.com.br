<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Initial Credits for New Companies
    |--------------------------------------------------------------------------
    |
    | This value determines the number of initial credits assigned to a new
    | company upon registration. You can adjust this value based on your
    | business requirements.
    |
    */

    'initial_credits' => env('INITIAL_CREDITS', 30),

    // custo em créditos por período de destaque
    'highlight_costs' => [
        7  => 10,
        15 => 18,
        30 => 32,
    ],
    'default_highlight_days' => 7,

    'home' => [
        // quantidade mínima de cards na home
        'min_cards'   => env('HOME_JOBS_MIN', 8),

        // se não houver destaque suficiente, preencher com vagas ativas aleatórias?
        'fill_random' => env('HOME_JOBS_FILL_RANDOM', true),
    ],

    'emails' => [
        // quantidade padrão de vagas recomendadas por email para candidatos
        'recommended_jobs_limit' => env('EMAIL_RECOMMENDED_JOBS_LIMIT', 10),
    ],
    
];