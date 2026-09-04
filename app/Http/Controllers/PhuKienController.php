<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham; 

class PhuKienController extends Controller
{
    public function index(Request $request)
    {
        // 1. Cố định lấy sản phẩm phụ kiện thuộc danh_muc_id = 5
        // Và đảm bảo cột anh_dai_dien không bị rỗng
        $query = SanPham::where('danh_muc_id', 5)
                        ->whereNotNull('anh_dai_dien')
                        ->where('anh_dai_dien', '!=', '');

        // 2. Lọc theo loại phụ kiện (Tab filter)
        if ($request->filled('type')) {
            switch ($request->type) {
                case 'bao_vot':
                    $query->where('ten_san_pham', 'LIKE', '%Bao%');
                    break;

                case 'cuoc':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%Cước%')
                          ->orWhere('ten_san_pham', 'LIKE', '%Dây%');
                    });
                    break;

                case 'cuon_can':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%Quấn cán%')
                          ->orWhere('ten_san_pham', 'LIKE', '%Cuốn cán%');
                    });
                    break;

                case 'bang_tay':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%Băng Tay%')
                          ->orWhere('ten_san_pham', 'LIKE', '%Băng Chặn Mồ Hôi%');
                    });
                    break;

                case 'bang_dau':
                    $query->where('ten_san_pham', 'LIKE', '%Băng Trán%');
                    break;

                case 'tat':
                    $query->where(function($q) {
                        $q->where('ten_san_pham', 'LIKE', '%Tất%')
                          ->orWhere('ten_san_pham', 'LIKE', '%Vớ%');
                    });
                    break;
            }
        }

        // 3. Lọc theo từ khóa tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('ten_san_pham', 'LIKE', '%' . $keyword . '%');
        }

        // 4. Sắp xếp giá hoặc ID
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

        // 5. Lấy danh sách và lọc bỏ các sản phẩm không có file ảnh thực tế trên ổ đĩa
        $danhSachPhuKien = $query->get()->filter(function ($item) {
            $imageName = SanPham::resolveImageName($item->anh_dai_dien ?? null);
            return file_exists(public_path('images/' . $imageName));
        });

        return view('phukien', compact('danhSachPhuKien'));
    }
}