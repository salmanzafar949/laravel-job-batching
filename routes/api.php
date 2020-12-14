<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::get('/upload', [SaleController::class, 'index']);
Route::post('/upload', [SaleController::class, 'store']);
Route::get('/batch', [SaleController::class, 'batch']);
Route::get('/batch/in-progress', [SaleController::class, 'batchInProgress']);
