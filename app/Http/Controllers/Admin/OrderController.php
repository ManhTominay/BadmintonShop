<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang; // Sử dụng đúng Model DonHang
use App\Models\DanhGia;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return $this->managementView('orders', $request);
    }

    public function vouchers()
    {
        return $this->managementView('vouchers');
    }

    public function cancellationReasons()
    {
        $cancelledOrders = DonHang::where('trang_thai_don_hang', 'da_huy')
            ->orderByDesc('id')
            ->paginate(15, ['*'], 'cancelled_page');

        $cancelledCount = DonHang::where('trang_thai_don_hang', 'da_huy')->count();
        $reasonSummary = DonHang::where('trang_thai_don_hang', 'da_huy')
            ->whereNotNull('ly_do_huy')
            ->selectRaw('ly_do_huy, COUNT(*) as total')
            ->groupBy('ly_do_huy')
            ->orderByDesc('total')
            ->get();

        return view('admin.orders.cancellation-reasons', compact('cancelledOrders', 'cancelledCount', 'reasonSummary'));
    }

    public function reviews()
    {
        $reviews = DanhGia::with(['sanPham', 'nguoiDung', 'donHang'])
            ->orderByDesc('created_at')
            ->paginate(15);
        $reviewCount = DanhGia::count();
        $averageRating = round((float) (DanhGia::avg('so_sao') ?? 0), 1);

        return view('admin.orders.reviews', compact('reviews', 'reviewCount', 'averageRating'));
    }

    private function managementView(string $section, ?Request $request = null)
    {
        $statusOptions = [
            'cho_xu_ly' => 'Chờ xác nhận',
            'dang_giao' => 'Đang giao',
            'cho_giao_hang' => 'Chờ giao hàng',
            'hoan_thanh' => 'Hoàn thành',
            'da_huy' => 'Đã hủy',
            'tra_hang' => 'Trả hàng',
            'hoan_tien' => 'Hoàn tiền',
        ];
        $selectedStatus = $request?->query('status');
        if (!array_key_exists($selectedStatus, $statusOptions)) {
            $selectedStatus = null;
        }

        $ordersQuery = DonHang::query();
        if ($section === 'orders' && $selectedStatus) {
            $ordersQuery->where('trang_thai_don_hang', $selectedStatus);
        }

        $orders = $section === 'orders'
            ? $ordersQuery->orderBy('id', 'desc')->paginate(10)->withQueryString()
            : collect();
        $statusCounts = $section === 'orders'
            ? DonHang::selectRaw('trang_thai_don_hang, COUNT(*) as total')->groupBy('trang_thai_don_hang')->pluck('total', 'trang_thai_don_hang')
            : collect();
        $vouchers = MaGiamGia::orderBy('id', 'desc')->get();

        return view('admin.orders.index', compact('orders', 'vouchers', 'section', 'statusOptions', 'selectedStatus', 'statusCounts'));
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
            'trang_thai' => 'required|in:cho_xu_ly,dang_giao,cho_giao_hang,hoan_thanh,da_huy,tra_hang,hoan_tien'
        ]);

        $order->update([
            'trang_thai_don_hang' => $request->trang_thai
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}