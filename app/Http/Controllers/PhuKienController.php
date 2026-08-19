<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham; 

class PhuKienController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy toàn bộ sản phẩm thuộc Danh mục Phụ kiện (danh_muc_id = 5)
        $query = SanPham::where('danh_muc_id', 5);

        // 2. Lọc theo nhóm phụ kiện cụ thể
        if ($request->filled('type')) {
            $type = $request->type;
            if ($type === 'bao_vot') {
                $query->where('ten_san_pham', 'LIKE', '%Bao Vợt%');
            } elseif ($type === 'cuoc') {
                $query->where('ten_san_pham', 'LIKE', '%Cước%');
            } elseif ($type === 'bang_tay') {
                $query->where('ten_san_pham', 'LIKE', '%Băng Chặn Mồ Hôi Tay%');
            } elseif ($type === 'bang_dau') {
                $query->where(function ($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Trán%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Đầu%');
                });
            } elseif ($type === 'cuon_can') {
                $query->where('ten_san_pham', 'LIKE', '%Cuốn Cán%');
            } elseif ($type === 'tat') {
                $query->where(function ($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Tất%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Vớ%');
                });
            }
        }

        // 3. Tìm kiếm theo từ khóa ô Search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }

        // 4. Sắp xếp giá hoặc theo ID
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('gia_co_ban', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('gia_co_ban', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $danhSachPhuKien = $query->get();

        // Đã sửa thành 'phukien' tương ứng với file resources/views/phukien.blade.php
        return view('phukien', compact('danhSachPhuKien'));
    }
}