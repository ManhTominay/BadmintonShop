<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham; // Hoặc Product

class CauController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm quả cầu lông
        $danhSachCau = SanPham::all(); 

        return view('cau.index', compact('danhSachCau'));
    }
}