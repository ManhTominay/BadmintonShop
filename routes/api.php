<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API lấy tất cả sản phẩm
Route::get('/products', function (Request $request) {
    $products = \App\Models\SanPham::with(['bienThes', 'thongSoVot'])
        ->where('trang_thai_kinh_doanh', true)
        ->orderBy('id', 'desc')
        ->get();
    
    return response()->json([
        'success' => true,
        'data' => $products,
        'total' => $products->count()
    ]);
});

// API lấy sản phẩm theo danh mục
Route::get('/products/category/{categoryId}', function (Request $request, $categoryId) {
    $products = \App\Models\SanPham::with(['bienThes', 'thongSoVot'])
        ->where('danh_muc_id', $categoryId)
        ->where('trang_thai_kinh_doanh', true)
        ->orderBy('id', 'desc')
        ->get();
    
    return response()->json([
        'success' => true,
        'data' => $products,
        'total' => $products->count()
    ]);
});
