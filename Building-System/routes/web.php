<?php

use Illuminate\Support\Facades\Route;

Route::get('/product', [ProductController::class, 'index'])->name('product.choise');
Route::get('/product/{type}', [ProductController::class, 'index'])->name('product.type');
Route::get('/product/{type}/{id}', [ProductController::class, 'index'])->name('product.view');


