<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\Authenticate;

Route::get('/', function () {
    return redirect()->route('auth.loginPage');
});


Route::get('/setSession', function() {
    session([
        'nama' => 'Ardyan Satya',
        'email' => 'ardyan.satya@gmail.com'
    ]);

    return 'Session telah ditambahkan';
});

Route::get('/getSession', function() {
    return session()->all();
});

Route::get('/deleteSession', function(){
    session()->flush();

    return 'Session sudah dihapus';
});


// Rute untuk homepage user terdaftar
Route::get('/{id?}', [UserDashboardController::class, "show"])->name('user-dashboard')->middleware(Authenticate::class);


// Route untuk measurement (CRUD)
Route::controller(MeasurementController::class)->middleware(Authenticate::class)->group(function(){
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

    Route::get('/measurements/{id}/detail/{measurementId}', 'show')->name('measurements.show');
});

Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function(){
    Route::get('/login', 'loginPage')->name('loginPage');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/register', 'registerPage')->name('registerPage');
    Route::post('/register', 'register')->name('register');
});