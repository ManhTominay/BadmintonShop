<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang danh sách Vợt cầu lông (Đã thêm ->name('vot-cau-long'))
Route::get('/vot-cau-long', [ProductController::class, 'votCauLong'])->name('vot-cau-long');

// Thêm sản phẩm vào giỏ hàng
Route::post('/gio-hang/them', [CartController::class, 'addToCart'])->name('cart.add');