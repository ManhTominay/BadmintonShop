<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CauController; 
use App\Http\Controllers\PhuKienController;
use App\Http\Controllers\AuthController;

// 1. Trang chủ & Danh mục sản phẩm
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/vot-cau-long', [ProductController::class, 'votCauLong'])->name('vot-cau-long');
Route::get('/giay-cau-long', [ProductController::class, 'giayCauLong'])->name('giay.index');
Route::get('/quan-ao', [ProductController::class, 'quanAo'])->name('quan-ao');
Route::get('/cau', [CauController::class, 'index'])->name('cau');
Route::get('/phu-kien', [PhuKienController::class, 'index'])->name('phukien');

// Route Chi tiết sản phẩm (Đã đưa ra ngoài để mọi người đều xem được)
Route::get('/san-pham/{id}', [ProductController::class, 'chiTietSanPham'])->name('san-pham.chi-tiet');

Route::get('/api/featured-products', [HomeController::class, 'getFeaturedProducts'])->name('featured.products');

// 2. Giỏ hàng
Route::post('/gio-hang/them', [CartController::class, 'addToCart'])->name('cart.add');

// 3. Xác thực người dùng (Authentication)
Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Đăng xuất (Dành cho user đã đăng nhập)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');