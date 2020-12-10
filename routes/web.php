<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('upload', fn() => view('upload-file'));

Route::post('upload', function(\Illuminate\Http\Request  $request){
    $data = array_map('str_getcsv',file($request->file));
    $header = $data[0];
    unset($data[0]);
    return $data;
})->name('upload.post');
