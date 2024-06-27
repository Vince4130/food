<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeasurementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('/measurements')->group(function () {
        Route::get('/index', [MeasurementController::class, 'index'])->name('measurements.index');
        Route::get('/show', [MeasurementController::class, 'index'])->name('measurements.show');
    });
    
});

require __DIR__.'/auth.php';
