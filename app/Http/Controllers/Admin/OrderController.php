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
            'hoan_tien' => 'Hoàn tiền',
        ];
        $selectedStatus = $request?->query('status');
        if (!array_key_exists($selectedStatus, $statusOptions)) {
            $selectedStatus = null;
        }

        $ordersQuery = DonHang::query();
        if ($section === 'orders' && $selectedStatus) {
            if ($selectedStatus === 'hoan_tien') {
                $ordersQuery->whereIn('trang_thai_don_hang', ['tra_hang', 'hoan_tien']);
            } else {
                $ordersQuery->where('trang_thai_don_hang', $selectedStatus);
            }
        }

        $orders = $section === 'orders'
            ? $ordersQuery->orderBy('id', 'desc')->paginate(10)
            : collect();
        if ($section === 'orders' && $request) {
            $orders->appends($request->query());
        }
        $statusCounts = $section === 'orders'
            ? DonHang::selectRaw('trang_thai_don_hang, COUNT(*) as total')->groupBy('trang_thai_don_hang')->pluck('total', 'trang_thai_don_hang')
            : collect();
        if ($section === 'orders') {
            $statusCounts->put('hoan_tien', ($statusCounts['tra_hang'] ?? 0) + ($statusCounts['hoan_tien'] ?? 0));
        }
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
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
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

        if ($request->input('trang_thai') === 'hoan_tien') {
            if (
                $order->trang_thai_don_hang !== 'tra_hang'
                || $order->trang_thai_thanh_toan !== 'da_thanh_toan'
            ) {
                return back()->withErrors(['order' => 'Chỉ có thể xác nhận hoàn tiền cho đơn đã thanh toán đang chờ hoàn tiền.']);
            }

            if (
                !$order->ngan_hang_hoan_tien
                || !$order->ten_chu_tai_khoan_hoan_tien
                || !$order->so_tai_khoan_hoan_tien
            ) {
                return back()->withErrors(['order' => 'Khách hàng cần cung cấp đầy đủ thông tin tài khoản trước khi xác nhận hoàn tiền.']);
            }
        }

        $order->update([
            'trang_thai_don_hang' => $request->trang_thai
        ]);

        return back()->with(
            'success',
            $request->input('trang_thai') === 'hoan_tien'
                ? 'Đã xác nhận chuyển tiền hoàn lại cho khách hàng.'
                : 'Đã cập nhật trạng thái đơn hàng thành công!'
        );
    }
}