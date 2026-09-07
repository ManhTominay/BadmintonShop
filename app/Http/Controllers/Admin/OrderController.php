<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang; // Sử dụng đúng Model DonHang
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return $this->managementView('orders');
    }

    public function vouchers()
    {
        return $this->managementView('vouchers');
    }

    private function managementView(string $section)
    {
        $orders = $section === 'orders'
            ? DonHang::orderBy('id', 'desc')->paginate(10)
            : collect();
        $vouchers = MaGiamGia::orderBy('id', 'desc')->get();

        return view('admin.orders.index', compact('orders', 'vouchers', 'section'));
    }

    public function storeVoucher(Request $request)
    {
        $voucher = $this->validateVoucher($request);
        MaGiamGia::create($voucher);

        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm voucher thành công!');
    }

    public function updateVoucher(Request $request, $id)
    {
        $voucherModel = MaGiamGia::findOrFail($id);
        $voucherModel->update($this->validateVoucher($request, $voucherModel->id));

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công!');
    }

    public function destroyVoucher($id)
    {
        MaGiamGia::findOrFail($id)->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Đã xóa voucher!');
    }

    private function validateVoucher(Request $request, ?int $voucherId = null): array
    {
        $validated = $request->validate([
            'ma_code' => ['required', 'string', 'max:50', Rule::unique('ma_giam_gia', 'ma_code')->ignore($voucherId)],
            'loai_giam_gia' => 'required|string|max:50',
            'gia_tri_giam' => 'required|numeric|min:0',
            'don_hang_toi_thieu' => 'required|numeric|min:0',
            'giam_toi_da' => 'required|numeric|min:0',
            'so_luong_dung' => 'required|integer|min:0',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'trang_thai' => 'required|string|max:50',
            'trang_thai_kich_hoat' => 'sometimes|boolean',
        ]);

        $validated['trang_thai_kich_hoat'] = $request->boolean('trang_thai_kich_hoat');

        return $validated;
    }

    public function show($id)
    {
        $order = DonHang::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = DonHang::findOrFail($id);
        
        $request->validate([
            'trang_thai' => 'required|in:Đang xử lý,Đang giao,Hoàn thành,Đã hủy'
        ]);

        $order->update([
            'trang_thai' => $request->trang_thai
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}