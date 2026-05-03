<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuilderController;

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
    Route::post('/components/{category}/{product}', [BuilderController::class, 'store'])->name('store');
    Route::delete('/components/{category}/{product}', [BuilderController::class, 'remove'])->name('remove');
    Route::get('/debug', [BuilderController::class, 'debug'])->name('debug');
});

Route::fallback(function () {
    return redirect()->route('home');
});
