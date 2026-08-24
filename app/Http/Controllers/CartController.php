<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'bien_the_id' => 'required',
            'so_luong' => 'required|integer|min:1',
            'cuoc_kem_bien_the_id' => 'nullable',
            'so_kg_cang' => 'nullable|numeric',
        ]);

        // Cố định user_id = 1 để khớp với dữ liệu trong database
        $userId = 1;

        $cartItem = GioHang::where('nguoi_dung_id', $userId)
            ->where('bien_the_id', $request->bien_the_id)
            ->where('cuoc_kem_bien_the_id', $request->cuoc_kem_bien_the_id)
            ->where('so_kg_cang', $request->so_kg_cang)
            ->first();

        if ($cartItem) {
            $cartItem->so_luong += $request->so_luong;
            $cartItem->save();
        } else {
            GioHang::create([
                'nguoi_dung_id' => $userId,
                'bien_the_id' => $request->bien_the_id,
                'so_luong' => $request->so_luong,
                'cuoc_kem_bien_the_id' => $request->cuoc_kem_bien_the_id,
                'so_kg_cang' => $request->so_kg_cang,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function index()
    {
        // Cố định user_id = 1 để khớp với bảng gio_hang hiện tại của bạn
        $userId = 1;

        // Lấy danh sách giỏ hàng từ database
        $gioHangs = GioHang::where('nguoi_dung_id', $userId)->get();

        $cart = [];
        foreach ($gioHangs as $item) {
            // Truy vấn trực tiếp bảng san_pham dựa vào bien_the_id
            $sanPham = DB::table('san_pham')->where('id', $item->bien_the_id)->first();

            $cart[$item->id] = [
                'ten'      => $sanPham->ten ?? $sanPham->ten_san_pham ?? 'Sản phẩm cầu lông',
                'gia'      => $sanPham->gia ?? $sanPham->gia_co_ban ?? 0,
                'anh'      => $sanPham->anh ?? $sanPham->anh_dai_dien ?? 'yonex_doura10.webp',
                'so_luong' => $item->so_luong,
            ];
        }

        return view('cart', compact('cart'));
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:1',
        ]);

        $cartItem = GioHang::find($id);
        if ($cartItem) {
            $cartItem->so_luong = $request->so_luong;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Đã cập nhật số lượng giỏ hàng!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cartItem = GioHang::find($id);
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}