<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
    // Trang tổng quan Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý sản phẩm (CRUD) sử dụng AdminProductController
    Route::resource('products', AdminProductController::class);

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/cancellation-reasons', [OrderController::class, 'cancellationReasons'])->name('orders.cancellationReasons');
    Route::get('/vouchers', [OrderController::class, 'vouchers'])->name('vouchers.index');
    Route::post('/vouchers', [OrderController::class, 'storeVoucher'])->name('vouchers.store');
    Route::put('/vouchers/{id}', [OrderController::class, 'updateVoucher'])->name('vouchers.update');
    Route::delete('/vouchers/{id}', [OrderController::class, 'destroyVoucher'])->name('vouchers.destroy');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Quản lý tài khoản (Đã chuyển sang dùng Route::resource để đầy đủ Thêm, Sửa, Xóa)
    Route::resource('users', UserController::class);
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
Route::redirect('/home', '/');
Route::get('/vot-cau-long', [ClientProductController::class, 'votCauLong'])->name('vot-cau-long');
Route::get('/giay-cau-long', [ClientProductController::class, 'giayCauLong'])->name('giay.index');
Route::get('/quan-ao', [App\Http\Controllers\ProductController::class, 'quanAo'])->name('quan-ao');
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

    // Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/password-reset-sent', [AuthController::class, 'showResetSentPage'])->name('password.sent');
    Route::get('/password-reset', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.token');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| 4. CÁC CHỨC NĂNG YÊU CẦU ĐĂNG NHẬP (Giỏ hàng, Thanh toán, Địa chỉ, Đăng xuất)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Giỏ hàng
    Route::post('/gio-hang/them/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/gio-hang/them-tat-ca', [CartController::class, 'addAllProducts'])->name('cart.add-all');
    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/gio-hang/cap-nhat/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/gio-hang/xoa/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/gio-hang/xoa-tat-ca', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/api/cart-count', [CartController::class, 'getCartCount'])->name('cart.count');
    
    // Điểm đến khi bấm nút thanh toán ở giỏ hàng (Kiểm tra địa chỉ lần đầu)
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout');

    // Trang điền địa chỉ giao hàng (chỉ hiện lần đầu nếu chưa có)
    Route::get('/thanh-toan/dia-chi', [CheckoutController::class, 'showAddressForm'])->name('checkout.address');
    Route::post('/thanh-toan/dia-chi', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');

    // Trang thay đổi địa chỉ người dùng hiện có
    Route::get('/thanh-toan/dia-chi/cap-nhat', [CheckoutController::class, 'editAddressForm'])->name('checkout.address.edit');
    Route::put('/thanh-toan/dia-chi/cap-nhat', [CheckoutController::class, 'updateAddress'])->name('checkout.address.update');

    // Trang checkout thanh toán thực tế
    Route::get('/thanh-toan/xac-nhan', [CheckoutController::class, 'showPaymentPage'])->name('checkout.payment');
    Route::post('/thanh-toan/dat-hang', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/thanh-toan/vietqr/{order}', [CheckoutController::class, 'showVietQr'])->name('payment.vietqr');

    // Tài khoản người dùng
    Route::get('/tai-khoan', [App\Http\Controllers\AccountController::class, 'profile'])->name('account.profile');
    Route::put('/tai-khoan', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.update-profile');
    Route::put('/tai-khoan/mat-khau', [App\Http\Controllers\AccountController::class, 'updatePassword'])->name('account.update-password');
    Route::get('/don-hang', [App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');
    Route::post('/don-hang/{id}/huy', [App\Http\Controllers\AccountController::class, 'cancelOrder'])->name('account.orders.cancel');
    Route::get('/tai-khoan/dia-chi', [App\Http\Controllers\AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/tai-khoan/dia-chi/mac-dinh/{id}', [App\Http\Controllers\AccountController::class, 'setDefaultAddress'])->name('account.addresses.default');

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('admin.logout');
    
});