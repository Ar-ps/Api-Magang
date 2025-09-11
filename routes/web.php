<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ApiController::class, 'dashboard'])->name('dashboard');

// route modular (per modul ambil API berbeda)
Route::get('/module/{name}', [ApiController::class, 'module'])->name('module.show');