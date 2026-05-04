<?php

use App\Http\Controllers\BuilderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("components.choose");
})->name("home");

Route::prefix('components')->name('components.')->group(function () {
    Route::get('/', [ProductController::class, 'selectCategories'])->name('choose');
    Route::get('/{category}', [ProductController::class, 'index'])->name('index');
    Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('builder')->name('builder.')->group(function () {
    Route::get('/', [BuilderController::class, 'index'])->name('index');
    Route::get('/builds', [BuilderController::class, 'allBuild'])->name('builds');
    Route::post('/builds/{build}/use', [BuilderController::class, 'use'])->name('use');
    Route::post('/components/{category}/{product}', [BuilderController::class, 'storeItem'])->name('storeItem');
    Route::delete('/components/{category}/{product}', [BuilderController::class, 'remove'])->name('remove');
    Route::get('/debug', [BuilderController::class, 'debug'])->name('debug');
    Route::middleware('auth')->group(function () {
        Route::get('/save', [BuilderController::class, 'create'])->name('create');
        Route::post('/save', [BuilderController::class, 'store'])->name('save');
    });
});

Route::fallback(function () {
    return redirect()->route('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
