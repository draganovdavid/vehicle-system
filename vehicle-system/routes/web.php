<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\CarModelController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    Route::middleware(['auth'])->group(function () {
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index');
        Route::post('/manufacturers', [ManufacturerController::class, 'store'])->name('manufacturers.store');
        Route::delete('/manufacturers/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('manufacturers.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/models', [CarModelController::class, 'index'])->name('models.index');
        Route::post('/models', [CarModelController::class, 'store'])->name('models.store');
        Route::delete('/models/{carModel}', [CarModelController::class, 'destroy'])->name('models.destroy');
    });

require __DIR__.'/auth.php';
