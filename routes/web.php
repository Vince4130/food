<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\MorphologyController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
        Route::get('/{measurement}/edit', [MeasurementController::class, 'edit'])->name('measurements.edit');
        Route::post('/update/{measurement}', [MeasurementController::class, 'update'])->name('measurements.update');
        Route::get('/delete/{measurement}', [MeasurementController::class, 'destroy'])->name('measurements.destroy');
    });
    
    Route::prefix('/morphologies')->group(function () {
        Route::get('/index', [MorphologyController::class, 'index'])->name('morphologies.index');
        Route::get('/create', [MorphologyController::class, 'create'])->name('morphologies.create');
        Route::post('/store', [MorphologyController::class, 'store'])->name('morphologies.store');
        Route::get('/{id}/edit', [MorphologyController::class, 'edit'])->name('morphologies.edit');
        Route::post('/update/{morphology}', [MorphologyController::class, 'update'])->name('morphologies.update');
        Route::delete('/delete/{morphology}', [MorphologyController::class, 'destroy'])->name('morphologies.destroy');
    });

    Route::prefix('/activities')->group(function () {
        Route::get('/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/store', [ActivityController::class, 'store'])->name('activities.store');
        Route::get('/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::post('/update/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    });

    Route::prefix('/targets')->group(function () {
        Route::get('/index', [TargetController::class, 'index'])->name('targets.index');
        Route::get('/show', [TargetController::class, 'show'])->name('targets.show');
        Route::match(['get', 'post'], '/{target}/edit', [TargetController::class, 'edit'])->name('targets.edit');
        Route::get('/create', [TargetController::class, 'create'])->name('targets.create');
        Route::post('/store', [TargetController::class, 'store'])->name('targets.store');
        Route::post('/update', [TargetController::class, 'update'])->name('targets.update');
    });
    
});

require __DIR__.'/auth.php';
