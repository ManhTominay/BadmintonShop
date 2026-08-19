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
        // Khởi tạo truy vấn lọc lấy sản phẩm (loại trừ giày, áo, quần)
        $query = SanPham::where('ten_san_pham', 'NOT LIKE', '%Giày%')
                        ->where('ten_san_pham', 'NOT LIKE', '%giay%')
                        ->where('ten_san_pham', 'NOT LIKE', '%Áo%')
                        ->where('ten_san_pham', 'NOT LIKE', '%ao%')
                        ->where('ten_san_pham', 'NOT LIKE', '%Quần%')
                        ->where('ten_san_pham', 'NOT LIKE', '%quan%');

        // Xử lý tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            // Chuẩn hóa từ khóa thương hiệu nâng cao (VD: lining, li-ning, li ning)
            $normalized = strtolower($keyword);
            if (in_array($normalized, ['lining', 'li-ning', 'li ning'])) {
                $query->where(function($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Li-Ning%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Lining%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Li Ning%');
                });
            } else {
                // Tìm kiếm thông thường theo từ khóa
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

        $danhSachVot = $query->get();

        return view('vot-cau-long', compact('danhSachVot'));
    }

    /**
     * Hiển thị danh sách giày cầu lông kết hợp Tìm kiếm thương hiệu & Sắp xếp
     */
    public function giayCauLong(Request $request)
    {
        // Khởi tạo truy vấn lọc lấy các sản phẩm là giày
        $query = SanPham::where(function($q) {
            $q->where('ten_san_pham', 'LIKE', '%Giày%')
              ->orWhere('ten_san_pham', 'LIKE', '%giay%');
        });

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
        // Khởi tạo truy vấn lọc lấy các sản phẩm là Quần hoặc Áo
        $query = SanPham::where(function($q) {
            $q->where('ten_san_pham', 'LIKE', '%Áo%')
              ->orWhere('ten_san_pham', 'LIKE', '%ao%')
              ->orWhere('ten_san_pham', 'LIKE', '%Quần%')
              ->orWhere('ten_san_pham', 'LIKE', '%quan%');
        });

        // Xử lý tìm kiếm từ khóa / thương hiệu
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

        // Xử lý sắp xếp
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