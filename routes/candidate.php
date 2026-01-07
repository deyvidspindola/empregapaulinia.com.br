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
        'App\Http\Controllers\Candidate\DashboardController@index'
    )->name('dashboard');

    Route::resource(
        '/meus-dados', 
        'App\Http\Controllers\Candidate\ProfileController'
    )
    ->only(['index', 'store', 'update'])
    ->names([
        'index' => 'profile.index',
        'store' => 'profile.store',
        'update' => 'profile.update',
    ]);

    Route::get('/minhas_candidaturas', function () {
        return view('employer.dashboard');
    })->name('candidaturas');

});