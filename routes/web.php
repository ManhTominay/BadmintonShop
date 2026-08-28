<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Khai báo các Controller phía Client (User)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController as ClientProductController;
use App\Http\Controllers\CauController; 
use App\Http\Controllers\PhuKienController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;

// Khai báo các Controller phía Admin (Sử dụng alias tránh trùng lặp tên ProductController)
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;


/*
|--------------------------------------------------------------------------
| 1. KHU VỰC QUẢN TRỊ ADMIN (Yêu cầu đăng nhập + Check phân quyền admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Kiểm tra nhanh quyền Admin trước khi vào các trang quản trị
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý sản phẩm (CRUD) sử dụng AdminProductController
    Route::resource('products', AdminProductController::class);

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Quản lý tài khoản & Khóa tài khoản
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/lock', [UserController::class, 'toggleLock'])->name('users.lock');

    // Cấu hình hệ thống
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

});


/*
|--------------------------------------------------------------------------
| 2. TRANG CHỦ & DANH MỤC SẢN PHẨM (Client)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/vot-cau-long', [ClientProductController::class, 'votCauLong'])->name('vot-cau-long');
Route::get('/giay-cau-long', [ClientProductController::class, 'giayCauLong'])->name('giay.index');
Route::get('/quan-ao', [ClientProductController::class, 'quanAo'])->name('quan-ao');
Route::get('/cau', [CauController::class, 'index'])->name('cau');
Route::get('/phu-kien', [PhuKienController::class, 'index'])->name('phukien');

// Chi tiết sản phẩm & Tìm kiếm
Route::get('/san-pham/{id}', [ClientProductController::class, 'chiTietSanPham'])->name('san-pham.chi-tiet');
Route::get('/tim-kiem', [ClientProductController::class, 'search'])->name('product.search');

Route::get('/api/featured-products', [HomeController::class, 'getFeaturedProducts'])->name('featured.products');


/*
|--------------------------------------------------------------------------
| 3. XÁC THỰC NGƯỜI DÙNG (Dành cho khách chưa đăng nhập - middleware 'guest')
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| 4. CÁC CHỨC NĂNG YÊU CẦU ĐĂNG NHẬP (Giỏ hàng, Thanh toán, Địa chỉ, Đăng xuất)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Giỏ hàng
    Route::post('/gio-hang/them/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/gio-hang/cap-nhat/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/gio-hang/xoa/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    
    // Điểm đến khi bấm nút thanh toán ở giỏ hàng (Kiểm tra địa chỉ lần đầu)
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout');

    // Trang điền địa chỉ giao hàng (chỉ hiện lần đầu nếu chưa có)
    Route::get('/thanh-toan/dia-chi', [CheckoutController::class, 'showAddressForm'])->name('checkout.address');
    Route::post('/thanh-toan/dia-chi', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');

    // Trang checkout thanh toán thực tế (hiển thị file checkout.blade.php của bạn)
    Route::get('/thanh-toan/xac-nhan', function (Request $request) {
        return view('checkout');
    })->name('checkout.payment');

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});