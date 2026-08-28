<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class CheckoutController extends Controller
{
    // Kiểm tra và điều hướng khi bấm thanh toán từ giỏ hàng
    public function index(Request $request)
    {
        $user = auth()->user();

        // Kiểm tra xem user này đã có địa chỉ trong bảng addresses chưa
        $address = Address::where('nguoi_dung_id', $user->id)->first();

        // Nếu chưa có địa chỉ -> Chuyển hướng sang trang điền địa chỉ lần đầu
        if (!$address) {
            return redirect()->route('checkout.address');
        }

        // Nếu đã có địa chỉ rồi -> Chuyển thẳng sang trang checkout chính thức kèm sản phẩm
        $items = $request->query('items');
        return redirect()->route('checkout.payment', ['items' => $items]);
    }

    // Hiển thị form điền địa chỉ cho lần đầu tiên
    public function showAddressForm()
    {
        return view('checkout-address');
    }

    // Lưu địa chỉ mới vào cơ sở dữ liệu
    public function storeAddress(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'tinh_thanh' => 'required|string|max:255',
            'phuong_xa' => 'required|string|max:255',
            'dia_chi_chi_tiet' => 'required|string|max:255',
        ]);

        Address::create([
            'nguoi_dung_id' => auth()->id(),
            'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
            'so_dien_thoai' => $request->so_dien_thoai,
            'tinh_thanh' => $request->tinh_thanh,
            'phuong_xa' => $request->phuong_xa,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
        ]);

        // Lưu xong thì chuyển tiếp sang trang thanh toán
        return redirect()->route('checkout.payment');
    }
}