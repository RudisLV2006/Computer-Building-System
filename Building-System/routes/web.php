<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuilderController;

Route::get('/', function(){
    return redirect()->route("products.index");
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{type}', [ProductController::class, 'listByType'])->name('products.byType');
Route::get('/products/{type}/{item}', [ProductController::class, 'showSpec'])->name('products.showSpec');



Route::get('/builder', [BuilderController::class, 'index'])->name('builder.index');
Route::get('/builder/{type}/{item}', [BuilderController::class, 'addItem'])->name('builder.addItem');
Route::get('/debug', [BuilderController::class, 'debug'])->name('builder.debug');