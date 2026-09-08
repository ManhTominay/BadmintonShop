<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\BienTheSanPham;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy đúng sản phẩm Vợt cầu lông (chỉ các cây vợt thực sự, loại trừ phụ kiện có chứa chữ Vợt)
        $votCaulong = SanPham::with(['bienThes', 'thongSoVot'])
            ->where('trang_thai_kinh_doanh', true)
            ->where(function($query) {
                $query->where('danh_muc_id', 1)
                    ->orWhere('ten_san_pham', 'LIKE', 'Vợt %')
                    ->orWhere('ten_san_pham', 'LIKE', '% Vợt %');
            })
            ->where('ten_san_pham', 'NOT LIKE', '%Cắm%')
            ->where('ten_san_pham', 'NOT LIKE', '%Dây%')
            ->where('ten_san_pham', 'NOT LIKE', '%Quấn cán%')
            ->where('ten_san_pham', 'NOT LIKE', '%Cuốn cán%')
            ->where('ten_san_pham', 'NOT LIKE', '%Bao%')
            ->where('ten_san_pham', 'NOT LIKE', '%Túi%')
            ->where('ten_san_pham', 'NOT LIKE', '%Balo%')
            ->where('ten_san_pham', 'NOT LIKE', '%Băng tay%')
            ->where('ten_san_pham', 'NOT LIKE', '%Băng trán%')
            ->where('ten_san_pham', 'NOT LIKE', '%Băng đầu%')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 2. Lấy 4 sản phẩm Giày cầu lông
        $giayCaulong = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 2)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 3. Lấy 4 sản phẩm Cầu cầu lông
        $cuocCaulong = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 3)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 4. Lấy 4 sản phẩm Quần áo cầu lông
        $quanAo = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 4)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 5. Lấy 4 sản phẩm Phụ kiện
        $phuKien = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->where('danh_muc_id', 5)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // 6. Lấy danh sách sản phẩm bán chạy/nổi bật để hiển thị đúng vòng lặp ở trang chủ
        $sanPhamBanChay = SanPham::with(['bienThes'])
            ->where('trang_thai_kinh_doanh', true)
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('votCaulong', 'giayCaulong', 'cuocCaulong', 'quanAo', 'phuKien', 'sanPhamBanChay'));
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
            $imageName = SanPham::resolveImageName($item->anh_dai_dien ?? null);
            return file_exists(public_path('images/' . $imageName));
        })->values();

        return response()->json($products);
    }
}