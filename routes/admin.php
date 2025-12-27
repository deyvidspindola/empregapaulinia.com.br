<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'role:allow,admin']], function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/empresas', function () {
        return view('admin.empresas.index');
    })->name('empresas');    

    Route::get('/candidatos', function () {
        return view('admin.candidatos.index');
    })->name('candidatos');    

    Route::get('/anuncios', function () {
        return view('admin.anuncios.index');
    })->name('anuncios');

    Route::get('/parametros', function () {
        return view('admin.dashboard');
    })->name('parametros');

    Route::get('/configuracoes', function () {
        return view('admin.configuracoes.index');
    })->name('configuracoes');    
});