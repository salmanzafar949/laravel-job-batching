<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SaleController;

Route::get('/', fn() => view('welcome'));

Route::get('upload', [SaleController::class, 'index']);

Route::post('upload', [SaleController::class, 'store'])->name('upload.post');
