<?php

Route::group([
    'prefix' => 'dashboard', 
    'as' => 'employer.', 
    'middleware' => [
        'auth', 
        'verified', 
        'dashboard', 
        'role:allow,employer'
    ]
], function () {

    Route::get(
        '/empresa', 
        'App\Http\Controllers\Employer\DashboardController@index'
    )->name('dashboard');
        
    Route::resource(
        '/vagas',
        'App\Http\Controllers\Employer\VagasController'
    );
    
    Route::get('/dados-da-empresa', 'App\Http\Controllers\Employer\ProfileController@index')
        ->name('profile.index');
    
    Route::post('/dados-da-empresa', 'App\Http\Controllers\Employer\ProfileController@store')
        ->name('profile.store');
    
    Route::put('/dados-da-empresa', 'App\Http\Controllers\Employer\ProfileController@update')
        ->name('profile.update');    


    Route::get('/candidatos', function () {
        return view('employer.candidatos.index');
    })->name('candidatos');    

    Route::get('/carteira', function () {
        return view('employer.carteira.index');
    })->name('carteira');

    Route::get('/planos', function () {
        return view('employer.planos.index');
    })->name('planos');

});