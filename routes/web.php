<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/input-glucose', function () {
    return view('input-glucose');
});