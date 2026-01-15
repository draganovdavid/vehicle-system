<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    // Vehicles listing available for any authenticated user (with filters)
    Route::middleware(['auth'])->group(function () {
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    });

    // Only admins can create/delete vehicles
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');


        // Admin user management
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Manufacturers: list for authenticated, admin required to create/delete
    // Manufacturers: admin only
    Route::middleware(['auth','admin'])->group(function () {
        Route::get('/manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index');
        Route::post('/manufacturers', [ManufacturerController::class, 'store'])->name('manufacturers.store');
        Route::delete('/manufacturers/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('manufacturers.destroy');
    });

    // Models: admin only
    Route::middleware(['auth','admin'])->group(function () {
        Route::get('/models', [CarModelController::class, 'index'])->name('models.index');
        Route::post('/models', [CarModelController::class, 'store'])->name('models.store');
        Route::delete('/models/{carModel}', [CarModelController::class, 'destroy'])->name('models.destroy');
    });

require __DIR__.'/auth.php';
