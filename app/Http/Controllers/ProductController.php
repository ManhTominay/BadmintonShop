<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function votCauLong(Request $request)
    {
        $query = SanPham::with('bienThes')
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 1);

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = trim($request->keyword);
            if (strtolower($keyword) == 'lining' || strtolower($keyword) == 'li-ning') {
                $query->where(function($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Li-Ning%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Lining%');
                });
            } else {
                $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
            }
        }

        $danhSachVot = $query->get();
        return view('vot-cau-long', compact('danhSachVot'));
    }

    public function giayCauLong(Request $request)
    {
        $query = SanPham::where('danh_muc_id', 4);

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

    public function quanAo(Request $request)
    {
        $query = SanPham::with('bienThes')
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 6);

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

        $danhSachQuanAo = $query->get();
        return view('quan-ao', compact('danhSachQuanAo'));
    }

    /**
     * Hiển thị danh sách phụ kiện với bộ lọc type tách bạch tuyệt đối
     */
    public function phuKien(Request $request)
    {
        $query = SanPham::where('danh_muc_id', 5);

        if ($request->filled('type') && $request->type != 'tat_ca') {
            $type = $request->type;

            switch ($type) {
                case 'tat':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%tất%')
                          ->orWhere('ten_san_pham', 'LIKE', '%vớ%');
                    })->where('ten_san_pham', 'NOT LIKE', '%bao vợt%')
                      ->where('ten_san_pham', 'NOT LIKE', '%túi đựng vợt%');
                    break;

                case 'bao_vot':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%bao vợt%')
                          ->orWhere('ten_san_pham', 'LIKE', '%túi đựng vợt%');
                    });
                    break;

                case 'cuoc':
                    $query->where('ten_san_pham', 'LIKE', '%cước%');
                    break;

                case 'cuon_can':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%cuốn cán%')
                          ->orWhere('ten_san_pham', 'LIKE', '%quấn cán%');
                    });
                    break;

                case 'bang_tay':
                    $query->where('ten_san_pham', 'LIKE', '%băng tay%');
                    break;

                case 'bang_dau':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%băng trán%')
                          ->orWhere('ten_san_pham', 'LIKE', '%băng đầu%');
                    });
                    break;
            }
        }

        // Lọc theo từ khóa tìm kiếm (nếu có)
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }

        $danhSachPhuKien = $query->get();
        return view('phu-kien', compact('danhSachPhuKien'));
    }

    public function chiTietSanPham($id)
    {
        // Tìm sản phẩm theo id hoặc slug, kèm theo biến thể (nếu có)
        $sanPham = SanPham::with('bienThes')->where('id', $id)->orWhere('slug', $id)->firstOrFail();

        // Lấy thêm sản phẩm liên quan cùng danh mục (tối đa 4 sản phẩm)
        $sanPhamLienQuan = SanPham::where('danh_muc_id', $sanPham->danh_muc_id)
            ->where('id', '!=', $sanPham->id)
            ->take(4)
            ->get();

        return view('xem-chi-tiet', compact('sanPham', 'sanPhamLienQuan'));
    }
}