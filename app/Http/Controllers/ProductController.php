<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hàm xử lý tìm kiếm toàn hệ thống (Độc lập với các danh mục)
     */
 public function search(Request $request)
{
    $keyword = trim($request->input('keyword'));
    $query = SanPham::query();

    if (!empty($keyword)) {
        $keywordLower = mb_strtolower($keyword);

        // Kiểm tra xem từ khóa có phải là tìm "áo" hoặc "quần áo" một cách chính xác không
        // Sử dụng khoảng trắng hoặc ranh giới từ để không bị nhầm với chữ "bao", "cao"...
        $isSearchingAo = ($keywordLower === 'áo' || $keywordLower === 'quan ao' || str_contains($keywordLower, ' áo ') || str_starts_with($keywordLower, 'áo ') || str_ends_with($keywordLower, ' áo'));

        if ($isSearchingAo) {
            $query->where(function($q) {
                $q->where('ten_san_pham', 'LIKE', '%áo%')
                  ->orWhere('ten_san_pham', 'LIKE', '%quần áo%');
            })
            // Loại bỏ các sản phẩm không liên quan như quả cầu, ống cầu hoặc bao vợt bị dính từ
            ->where('ten_san_pham', 'NOT LIKE', '%quả cầu%')
            ->where('ten_san_pham', 'NOT LIKE', '%ống cầu%')
            ->where('ten_san_pham', 'NOT LIKE', '%bao vợt%');
        } else {
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }
    }

    $sanPhams = $query->get();

    // Trả về đúng tên tệp view 'search-results' của bạn
    return view('pages.search-results', compact('sanPhams', 'keyword'));
}

    public function votCauLong(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $query = SanPham::with('bienThes')
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 1);

        if ($keyword !== '') {
            if (strtolower($keyword) == 'lining' || strtolower($keyword) == 'li-ning') {
                $query->where(function($q) {
                    $q->where('ten_san_pham', 'LIKE', '%Li-Ning%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Lining%');
                });
            } else {
                $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
            }
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('gia_co_ban', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('gia_co_ban', 'desc');
            } else {
                $query->orderByRaw("CASE
                    WHEN ten_san_pham LIKE '%Yonex%' THEN 1
                    WHEN ten_san_pham LIKE '%Victor%' THEN 2
                    WHEN ten_san_pham LIKE '%Li-Ning%' OR ten_san_pham LIKE '%Lining%' THEN 3
                    WHEN ten_san_pham LIKE '%Mizuno%' THEN 4
                    ELSE 5
                END ASC")
                ->orderBy('gia_co_ban', 'asc');
            }
        } else {
            $query->orderByRaw("CASE
                    WHEN ten_san_pham LIKE '%Yonex%' THEN 1
                    WHEN ten_san_pham LIKE '%Victor%' THEN 2
                    WHEN ten_san_pham LIKE '%Li-Ning%' OR ten_san_pham LIKE '%Lining%' THEN 3
                    WHEN ten_san_pham LIKE '%Mizuno%' THEN 4
                    ELSE 5
                END ASC")
                ->orderBy('gia_co_ban', 'asc');
        }

        $danhSachVot = $query->get();
        return view('vot-cau-long', compact('danhSachVot'));
    }

    public function giayCauLong(Request $request)
    {
        $query = SanPham::where('danh_muc_id', 2);

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
            $query->orderByRaw("CASE
                    WHEN ten_san_pham LIKE '%Yonex%' THEN 1
                    WHEN ten_san_pham LIKE '%Victor%' THEN 2
                    WHEN ten_san_pham LIKE '%Li-Ning%' OR ten_san_pham LIKE '%Lining%' THEN 3
                    WHEN ten_san_pham LIKE '%Mizuno%' THEN 4
                    ELSE 5
                END ASC")
                ->orderBy('gia_co_ban', 'asc');
        }

        $danhSachGiay = $query->get();
        return view('giay', compact('danhSachGiay'));
    }

    public function quanAo(Request $request)
{
    $query = SanPham::with('bienThes')
        ->where('trang_thai_kinh_doanh', true)
        ->where('danh_muc_id', 4);

    // Lọc theo thương hiệu (brand) từ các nút bấm ở giao diện
    if ($request->filled('brand')) {
        $brand = trim($request->brand);
        $query->where(function ($q) use ($brand) {
            $q->where('ten_san_pham', 'LIKE', '%' . $brand . '%');
            
            // Xử lý riêng trường hợp Lining/Li-Ning hay bị lệch ký tự gạch ngang
            if (strtolower($brand) === 'lining' || strtolower($brand) === 'li-ning') {
                $q->orWhere('ten_san_pham', 'LIKE', '%Li-Ning%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Lining%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Li Ning%');
            }

            $q->orWhereHas('thuongHieu', function ($brandQuery) use ($brand) {
                $brandQuery->where('ten_thuong_hieu', 'LIKE', '%' . $brand . '%');
            });
        });
    }

    // Lọc theo từ khóa tìm kiếm trên thanh input header
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
    if ($request->filled('sort')) {
        if ($request->sort === 'price_asc') {
            $query->orderBy('gia_co_ban', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('gia_co_ban', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }
    } else {
        $query->orderBy('id', 'desc');
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

        $query->orderByRaw("CASE
                WHEN ten_san_pham LIKE '%Yonex%' THEN 1
                WHEN ten_san_pham LIKE '%Victor%' THEN 2
                WHEN ten_san_pham LIKE '%Li-Ning%' OR ten_san_pham LIKE '%Lining%' THEN 3
                WHEN ten_san_pham LIKE '%Mizuno%' THEN 4
                ELSE 5
            END ASC")
            ->orderBy('gia_co_ban', 'asc');

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