<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;
use App\Http\Controllers\ApiController;

// ambil semua data modul dari database (untuk dashboard frontend)
Route::get('/api-data', [ApiDataController::class, 'index'])->name('api.data.index');

// ambil data modul tertentu dari database
Route::get('/api-data/{module}', [ApiDataController::class, 'show'])->name('api.data.show');

// simpan data manual ke api_data (opsional, fallback modul tanpa tabel)
Route::post('/store-api-data', [ApiDataController::class, 'store'])->name('api.data.store');

// kalau frontend butuh refresh data dari API eksternal
Route::get('/refresh/{name}', [ApiController::class, 'module'])->name('api.refresh.module');