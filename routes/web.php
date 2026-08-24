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

// Route Chi tiết sản phẩm
Route::get('/san-pham/{id}', [ProductController::class, 'chiTietSanPham'])->name('san-pham.chi-tiet');

// Route Tìm kiếm sản phẩm
Route::get('/tim-kiem', [ProductController::class, 'search'])->name('product.search');

Route::get('/api/featured-products', [HomeController::class, 'getFeaturedProducts'])->name('featured.products');

// 2. Xác thực người dùng (Chỉ dành cho khách chưa đăng nhập)
Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Các chức năng yêu cầu bắt buộc phải ĐĂNG NHẬP mới được dùng (Giỏ hàng, v.v.)
Route::middleware(['auth'])->group(function () {
    // Thêm giỏ hàng
    Route::post('/gio-hang/them/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    
    // Hiển thị giỏ hàng
    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');

    // Cập nhật và Xóa sản phẩm trong giỏ hàng
    Route::patch('/gio-hang/cap-nhat/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/gio-hang/xoa/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    
    // 👇 THÊM ROUTE CHECKOUT NÀY VÀO ĐỂ HẾT LỖI
    Route::get('/thanh-toan', function () {
        return view('checkout'); // Hoặc trỏ tới Controller xử lý thanh toán của bạn
    })->name('checkout');

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});