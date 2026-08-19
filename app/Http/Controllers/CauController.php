<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham; 

class CauController extends Controller
{
    public function index(Request $request)
    {
        // Chỉ lấy sản phẩm thuộc danh mục Cầu Cầu Lông (danh_muc_id = 3)
        $query = SanPham::where('danh_muc_id', 3);

        // Lọc theo từ khóa nếu dùng ô tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }

        // Sắp xếp giá
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('gia_co_ban', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('gia_co_ban', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $danhSachCau = $query->get();

        return view('cau', compact('danhSachCau'));
    }
}