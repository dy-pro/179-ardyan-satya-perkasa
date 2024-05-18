<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    return view('home', [
        "name" => $request->name,
        "email" => $request->email
        // 'id' => 1,
        // 'name' => 'Ardyan Satya',
        // 'email' => 'ardyan.satya@gmail.com'
    ]);
});

Route::get('/input-glucose', function (Request $request) {
    return view('input-glucose', [
        "name" => $request->name,
        "email" => $request->email
    ]);
});

Route::get('/input-cholesterol', function (Request $request) {
    return view('input-cholesterol', [
        "name" => $request->name,
        "email" => $request->email
    ]);
});

Route::get('/input-urid-acid', function (Request $request) {
    return view('input-urid-acid', [
        "name" => $request->name,
        "email" => $request->email
    ]);
});

Route::get('/history', function (Request $request) {
    return view('history', [
        "name" => $request->name,
        "email" => $request->email
    ]);
});