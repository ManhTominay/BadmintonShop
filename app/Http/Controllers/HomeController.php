<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\BienTheSanPham;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy đúng sản phẩm Vợt cầu lông (Chỉ lấy cây vợt thực sự, loại trừ quấn cán, bao, túi, balo)
        $votCaulong = SanPham::with(['bienThes', 'thongSoVot'])
            ->where('trang_thai_kinh_doanh', true)
            ->where(function($query) {
                $query->where('ten_san_pham', 'LIKE', 'Vợt %')
                      ->orWhere('ten_san_pham', 'LIKE', '% Vợt %');
            })
            ->where('ten_san_pham', 'NOT LIKE', '%Cuốn cán%')
            ->where('ten_san_pham', 'NOT LIKE', '%Bao%')
            ->where('ten_san_pham', 'NOT LIKE', '%Túi%')
            ->where('ten_san_pham', 'NOT LIKE', '%Balo%')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 2. Lấy 4 sản phẩm Giày cầu lông
        $giayCaulong = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('ten_san_pham', 'LIKE', '%Giày%')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 3. Lấy 4 sản phẩm Cước cầu lông
        $cuocCaulong = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where(function($query) {
                $query->where('ten_san_pham', 'LIKE', '%Cước%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Dây%');
            })
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 4. Lấy 4 sản phẩm Phụ kiện (Bao vợt, Quấn cán, v.v.)
        $phuKien = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where(function($query) {
                $query->where('ten_san_pham', 'LIKE', '%Phụ kiện%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Quấn cán%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Bao%')
                      ->orWhere('ten_san_pham', 'LIKE', '%Túi%');
            })
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('votCaulong', 'giayCaulong', 'cuocCaulong', 'phuKien'));
    }

    // Hàm xử lý AJAX khi bấm các tab sản phẩm nổi bật/mới/sale
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
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->get()->filter(function ($item) {
            return !$item->anh_dai_dien || file_exists(public_path('images/' . ltrim($item->anh_dai_dien, '/')));
        })->values();

        return response()->json($products);
    }
}