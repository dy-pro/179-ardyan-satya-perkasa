<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\UserDashboardController;

// Route untuk homepage guest user
Route::get('/', function () {
    return 'hello world';
});


// Rute untuk homepage user terdaftar
Route::get('/{id?}', [UserDashboardController::class, "show"])->name('user-dashboard');


// Route untuk measurement (CRUD)
Route::controller(MeasurementController::class)->group(function(){
    Route::get('/measurements/{id}', 'index')
        ->name('measurements.index');

    Route::get('/measurements/{inputType}/{id}', 'create')
        ->name('measurements.input');

    Route::post('/measurements/{inputType}/{id}', 'store')
        ->name('measurements.store');
    
    Route::get('/measurements/{id}/edit/{measurementId}', 'edit')
        ->name('measurements.edit');
    
    Route::put('/measurements/{id}/update/{measurementId}', 'update')
        ->name('measurements.update');
    
    Route::delete('/measurements/{id}/{measurementId}', 'destroy')
        ->name('measurements.destroy');
});

// Session

Route::get('/setSession', function(){
    session([
        'nama' => 'Ardyan Satya',
        'email' => 'ardyan.satya@gmail.com',
        'dob' => '2 Juni 1992',
    ]);

    return 'Session Telah Ditambahkan';

});


Route::get('/getSession', function(){
    return([
        'nama' => session()->get('nama'),
        'email' => session()->get('email'),
        'dob' => session()->get('dob'),
    ]);

});
