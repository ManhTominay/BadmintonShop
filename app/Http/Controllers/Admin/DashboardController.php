<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kiểm tra phân quyền admin
        if (auth()->user()->vai_tro !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang quản trị!');
        }
        
        // Thống kê số liệu tổng quan
        $tongSoNguoiDung = DB::table('nguoi_dung')->count();
        $tongSoSanPham   = DB::table('san_pham')->count();
        $tongDonHang     = DB::table('don_hang')->count();
        $tongDoanhThu    = DB::table('don_hang')->where('trang_thai_thanh_toan', 'DA_THANH_TOAN')->sum('tong_thanh_toan');

        // Lấy danh sách người dùng và đơn hàng gần đây
        $users  = DB::table('nguoi_dung')->orderBy('id', 'DESC')->limit(10)->get();
        $orders = DB::table('don_hang')->orderBy('ngay_tao', 'DESC')->limit(10)->get();

        return view('admin.dashboard', compact(
            'tongSoNguoiDung', 
            'tongSoSanPham', 
            'tongDonHang', 
            'tongDoanhThu', 
            'users', 
            'orders'
        ));
    }
}