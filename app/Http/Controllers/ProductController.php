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
        // Khởi tạo truy vấn lọc lấy sản phẩm
        $query = SanPham::where('ten_san_pham', 'NOT LIKE', '%Giày%');

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
}