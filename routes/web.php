<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('upload', fn() => view('upload-file'));

Route::post('upload', fn(\Illuminate\Http\Request  $request) => $request->all());
