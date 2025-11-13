<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function(){
    return redirect()->route("products.index");
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{type}', [ProductController::class, 'listByType'])->name('products.byType');
Route::get('/products/{type}/{spec}', [ProductController::class, 'showSpec'])->name('products.showSpec');


