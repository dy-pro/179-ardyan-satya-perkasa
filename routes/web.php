<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeasurementController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return redirect()->route('auth.loginPage');
});


// Rute untuk homepage user terdaftar
Route::get('/{id?}', [UserDashboardController::class, "show"])
    ->name('user-dashboard')
    ->middleware(Authenticate::class);

// Route untuk Auth
Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function(){
    Route::get('/login', 'loginPage')
        ->name('loginPage')
        ->middleware(RedirectIfAuthenticated::class);

    Route::post('/login', 'login')
        ->name('login');

    Route::get('/logout', 'logout')
        ->name('logout');

    Route::get('/register', 'registerPage')
        ->name('registerPage')
        ->middleware(RedirectIfAuthenticated::class);
        
    Route::post('/register', 'register')
        ->name('register');
});

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


// API untuk visualiasi data
Route::get('/glucose-data/{id}', [UserDashboardController::class, 'getGlucoseData'])->name('glucose-data');

Route::get('/cholesterol-data/{id}', [UserDashboardController::class, 'getCholesterolData'])->name('cholesterol-data');

Route::get('/uric-acid-data/{id}', [UserDashboardController::class, 'getUricAcidData'])->name('uric-acid-data');

Route::get('/heart-rate-data/{id}', [UserDashboardController::class, 'getHeartRateData'])->name('heart-rate-data');