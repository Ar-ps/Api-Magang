<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;

Route::post('/store-api-data', [ApiDataController::class, 'store'])
    ->name('store.api.data');