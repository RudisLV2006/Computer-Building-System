<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/product', [ProductController::class, 'index'])->name('product.choise');
Route::get('/product/{type}', [ProductController::class, 'type'])->name('product.type');
Route::get('/product/{type}/{spec}', [ProductController::class, 'showSpec'])->name('product.view');


