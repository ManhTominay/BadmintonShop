<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách vợt cầu lông kết hợp Tìm kiếm thương hiệu & Sắp xếp
     */
    public function votCauLong(Request $request)
{
    // Lấy đúng danh_muc_id = 1
    $query = SanPham::where('danh_muc_id', 1);

    if ($request->filled('keyword')) {
        $keyword = trim($request->keyword);
        $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
    }

    if ($request->sort == 'price_asc') {
        $query->orderBy('gia_co_ban', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('gia_co_ban', 'desc');
    } else {
        $query->orderBy('id', 'desc');
    }

    $danhSachVot = $query->get();

    return view('vot-cau-long', compact('danhSachVot'));
}

    /**
     * Hiển thị danh sách giày cầu lông kết hợp Tìm kiếm thương hiệu & Sắp xếp
     */
    public function giayCauLong(Request $request)
    {
        // Lọc chính xác theo danh_muc_id = 4 (Giày Cầu Lông)
        $query = SanPham::where('danh_muc_id', 4);

        // Xử lý tìm kiếm theo thương hiệu / từ khóa
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            // Chuẩn hóa từ khóa thương hiệu
            $normalized = strtolower($keyword);
            if (in_array($normalized, ['lining', 'li-ning', 'li ning'])) {
                $query->where(function($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Li-Ning%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Lining%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Li Ning%');
                });
            } else {
                $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
            }
        }

        // Xử lý sắp xếp theo giá / mới nhất
        if ($request->sort == 'price_asc') {
            $query->orderBy('gia_co_ban', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('gia_co_ban', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $danhSachGiay = $query->get();
    return view('giay', compact('danhSachGiay'));
    }

    /**
     * Hiển thị danh sách quần áo cầu lông
     */
    public function quanAo(Request $request)
{
    // BẮT BUỘC: danh_muc_id = 6 VÀ KHÔNG CHỨA từ "Quả", "Cầu", "Tất", "Bao vợt"
    $query = SanPham::where('danh_muc_id', 6)
                    ->where('ten_san_pham', 'NOT LIKE', '%Quả%')
                    ->where('ten_san_pham', 'NOT LIKE', '%Cầu Lông Ba Sao%')
                    ->where('ten_san_pham', 'NOT LIKE', '%Tất%')
                    ->where('ten_san_pham', 'NOT LIKE', '%Bao vợt%');

    // Tìm kiếm theo từ khóa / thương hiệu (chỉ chạy khi keyword thực sự có dữ liệu)
    if ($request->filled('keyword')) {
        $keyword = trim($request->keyword);
        $normalized = strtolower($keyword);

        if (in_array($normalized, ['lining', 'li-ning', 'li ning'])) {
            $query->where(function($q) {
                $q->where('ten_san_pham', 'LIKE', '%Li-Ning%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Lining%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Li Ning%');
            });
        } else {
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }
    }

    // Sắp xếp
    if ($request->sort == 'price_asc') {
        $query->orderBy('gia_co_ban', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('gia_co_ban', 'desc');
    } else {
        $query->orderBy('id', 'desc');
    }

    $danhSachQuanAo = $query->get();

    return view('quan-ao', compact('danhSachQuanAo'));
}
}