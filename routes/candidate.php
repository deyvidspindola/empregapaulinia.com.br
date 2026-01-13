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


    Route::get('/meus-dados', 'App\Http\Controllers\Candidate\ProfileController@index')
        ->name('profile.index');
    
    Route::post('/meus-dados', 'App\Http\Controllers\Candidate\ProfileController@store')
        ->name('profile.store');
    
    Route::put('/meus-dados', 'App\Http\Controllers\Candidate\ProfileController@update')
        ->name('profile.update');


    Route::get('/minhas_candidaturas', function () {
        return view('employer.dashboard');
    })->name('candidaturas');

});