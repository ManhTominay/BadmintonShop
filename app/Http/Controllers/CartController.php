<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;

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

        $userId = auth()->id() ?? 1;

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
}