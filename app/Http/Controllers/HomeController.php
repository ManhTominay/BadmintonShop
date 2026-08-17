<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\BienTheSanPham;

class HomeController extends Controller
{
    public function index()
    {
        $sanPhams = SanPham::with(['bienThes', 'thongSoVot'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('la_san_pham_noi_bat', true)
            ->take(4)
            ->get();

        $danhSachCuoc = BienTheSanPham::whereHas('sanPham', function($query) {
            $query->where('ten_san_pham', 'LIKE', '%Cước%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Dây%');
        })->get();

        return view('home', compact('sanPhams', 'danhSachCuoc'));
    }
}