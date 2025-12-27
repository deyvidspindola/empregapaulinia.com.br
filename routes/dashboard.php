<?php

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified', 'dashboard', 'role:deny,admin']], function () {

    Route::get('/', function () {
        return view('dashboard.dashboard');
    });    

    Route::get('/alterar_senha', function () {
        return view('dashboard.dashboard');
    })->name('alterar_senha');

    // employer routes
    Route::group(['as' => 'dashboard.', 'middleware' => ['role:allow,employer']], function () {

        Route::get('/empresa', 'App\Http\Controllers\Dashboard\CompanyDashboardController@index')->name('dashboard');
        
        Route::resource('/vagas', 'App\Http\Controllers\Dashboard\VagasController');
        Route::resource('/dados-da-empresa', 'App\Http\Controllers\Dashboard\DadosDaEmpresaController')
            ->only(['index', 'store', 'update']);


        Route::get('/candidatos', function () {
            return view('dashboard.candidatos.index');
        })->name('candidatos');    

        Route::get('/carteira', function () {
            return view('dashboard.carteira.index');
        })->name('carteira');

        Route::get('/planos', function () {
            return view('dashboard.planos.index');
        })->name('planos');

    });

    // candidate routes
    Route::group(['as' => 'candidate.', 'middleware' => ['role:allow,candidate']], function () {

        Route::get('/candidato', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');

        Route::get('/meus_dados', function () {
            return view('dashboard.dashboard');
        })->name('perfil');

        Route::get('/minhas_candidaturas', function () {
            return view('dashboard.dashboard');
        })->name('candidaturas');

    });

});