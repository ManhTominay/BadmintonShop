<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CauController; // Khai báo thêm CauController

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang danh sách Vợt cầu lông
Route::get('/vot-cau-long', [ProductController::class, 'votCauLong'])->name('vot-cau-long');

// Trang danh sách Giày cầu lông
Route::get('/giay-cau-long', [ProductController::class, 'giayCauLong'])->name('giay.index');

// Trang danh sách quần áo
Route::get('/quan-ao', [ProductController::class, 'quanAo'])->name('quan-ao');

// Trang danh sách cầu thi đấu
Route::get('/cau', [CauController::class, 'index'])->name('cau');

// Thêm sản phẩm vào giỏ hàng
Route::post('/gio-hang/them', [CartController::class, 'addToCart'])->name('cart.add');