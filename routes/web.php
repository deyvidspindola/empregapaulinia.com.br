<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/', 
    [App\Http\Controllers\HomeController::class, 'index']
)->name('home');

Route::group(['prefix' => 'vagas'], function () {
    Route::get('/', [App\Http\Controllers\Web\VagasController::class, 'index'])->name('jobs');
    Route::get('/{city}/{slugOrId}', [App\Http\Controllers\Web\VagasController::class, 'show'])
        ->where('slugOrId', '[A-Za-z0-9\-]+') 
        ->name('jobs.show');
});

# Aplicação para vaga (precisa estar logado como candidato)
Route::get('vaga/{job}/apply', function() {
    return view('web.vagas.apply-popup', [
        'jobId' => request()->route('job'),
    ]);
})->whereNumber('job')
  ->name('jobs.apply.popup');

Route::post('vaga/{job}/apply', [App\Http\Controllers\Web\VagasController::class, 'apply'])
    ->whereNumber('job')
    ->middleware('auth', 'apply')
    ->name('jobs.apply');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/employer.php';
require __DIR__.'/candidate.php';