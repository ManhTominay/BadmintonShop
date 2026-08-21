<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\BienTheSanPham;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy TOÀN BỘ sản phẩm đang kinh doanh (bỏ take(4) và bỏ điều kiện chỉ lấy sản phẩm nổi bật)
        $sanPhams = SanPham::with(['bienThes', 'thongSoVot'])
            ->where('trang_thai_kinh_doanh', true)
            ->orderBy('id', 'desc')
            ->get();

        $danhSachCuoc = BienTheSanPham::whereHas('sanPham', function($query) {
            $query->where('ten_san_pham', 'LIKE', '%Cước%')
                  ->orWhere('ten_san_pham', 'LIKE', '%Dây%');
        })->get();

        return view('home', compact('sanPhams', 'danhSachCuoc'));
    }

    // Hàm xử lý AJAX khi bấm các tab
    public function getFeaturedProducts(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = SanPham::with('bienThes')
                        ->where('trang_thai_kinh_doanh', true);

        switch ($type) {
            case 'new':
                $query->where('la_san_pham_moi', true)->orderBy('created_at', 'desc');
                break;
            case 'hot':
                $query->where('la_san_pham_noi_bat', true)->orderBy('id', 'desc');
                break;
            case 'sale':
                $query->whereNotNull('gia_khuyen_mai')->where('gia_khuyen_mai', '>', 0);
                break;
            default:
                $query->orderBy('id', 'desc'); // 'all' lấy toàn bộ danh sách sản phẩm
                break;
        }

        $products = $query->get()->filter(function ($item) {
            return !$item->anh_dai_dien || file_exists(public_path('images/' . ltrim($item->anh_dai_dien, '/')));
        })->values();

        return response()->json($products);
    }
}