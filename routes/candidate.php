<?php

Route::group([
    'prefix' => 'dashboard', 
    'as' => 'candidate.',
    'middleware' => [
        'auth', 
        'verified', 
        'dashboard', 
        'role:allow,candidate'
    ]
], function () {

    Route::get(
        '/candidato', 
        'App\Http\Controllers\Dashboard\CandidateDashboardController@index'
    )->name('dashboard');

    Route::get('/meus_dados', function () {
        return view('employer.dashboard');
    })->name('perfil');

    Route::get('/minhas_candidaturas', function () {
        return view('employer.dashboard');
    })->name('candidaturas');

});