<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang; // Sử dụng đúng Model DonHang
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Sắp xếp theo id hoặc ngay_tao giảm dần vì bảng không dùng created_at chuẩn
        $orders = DonHang::orderBy('id', 'desc')->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'trang_thai' => 'required|in:Đang xử lý,Đang giao,Hoàn thành,Đã hủy'
        ]);

        $order->update([
            'trang_thai' => $request->trang_thai
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}