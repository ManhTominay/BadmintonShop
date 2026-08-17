<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/gio-hang/them', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');