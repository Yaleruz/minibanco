<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetiroController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('cuentas', App\Http\Controllers\CuentaController::class);
Route::resource('clientes', App\Http\Controllers\ClienteController::class);
Route::resource('tipo_cuentas', App\Http\Controllers\TipoCuentaController::class);
Route::resource('retiros', App\Http\Controllers\RetiroController::class);
Route::get('/retiros', [RetiroController::class, 'index'])->name('retiros.index');
Route::post('/retiros', [RetiroController::class, 'retirar'])->name('retiros.retirar');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
