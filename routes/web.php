<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeasurementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('/measurements')->group(function () {
        Route::get('/index', [MeasurementController::class, 'index'])->name('measurements.index');
        Route::get('/show', [MeasurementController::class, 'show'])->name('measurements.show');
        Route::get('/create', [MeasurementController::class, 'create'])->name('measurements.create');
        Route::post('/store', [MeasurementController::class, 'store'])->name('measurements.store');
        Route::post('/store', [MeasurementController::class, 'store'])->name('measurements.store');
        Route::get('/{measurement}/edit', [MeasurementController::class, 'edit'])->name('measurements.edit');
        Route::post('/update/{measurement}', [MeasurementController::class, 'update'])->name('measurements.update');
        Route::get('/delete/{measurement}', [MeasurementController::class, 'destroy'])->name('measurements.destroy');
    });
    
});

require __DIR__.'/auth.php';
