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
    
    Route::resource(
        '/dados-da-empresa', 
        'App\Http\Controllers\Employer\ProfileController'
    )
    ->only(['index', 'store', 'update'])
    ->names([
        'index' => 'profile.index',
        'store' => 'profile.store',
        'update' => 'profile.update',
    ]);    


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