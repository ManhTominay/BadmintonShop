<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Address;
use App\Models\DonHang;

class AccountController extends Controller
{
    /**
     * Show the user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        
        return view('account.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show the user's orders
     */
    public function orders(Request $request)
    {
        $user = Auth::user();

        $status = $request->query('status', 'cho_thanh_toan');
        $allowedStatuses = ['cho_thanh_toan', 'cho_giao_hang', 'van_chuyen', 'hoan_thanh', 'da_huy', 'tra_hang'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'cho_thanh_toan';
        }

        $baseQuery = DonHang::where('nguoi_dung_id', $user->id)
            ->with(['chiTietDonHangs.sanPham', 'chiTietDonHangs.bienThe']);
        $ordersQuery = (clone $baseQuery);

        match ($status) {
            'cho_thanh_toan' => $ordersQuery->where('trang_thai_don_hang', 'cho_xu_ly'),
            'cho_giao_hang' => $ordersQuery->where('trang_thai_don_hang', 'cho_giao_hang'),
            'van_chuyen' => $ordersQuery->where('trang_thai_don_hang', 'dang_giao'),
            'hoan_thanh' => $ordersQuery->where('trang_thai_don_hang', 'hoan_thanh'),
            'da_huy' => $ordersQuery->where('trang_thai_don_hang', 'da_huy'),
            'tra_hang' => $ordersQuery->whereIn('trang_thai_don_hang', ['tra_hang', 'hoan_tien']),
        };

        $orders = $ordersQuery
            ->orderBy('ngay_tao', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $orderCounts = [
            'cho_thanh_toan' => (clone $baseQuery)->where('trang_thai_don_hang', 'cho_xu_ly')->count(),
            'cho_giao_hang' => (clone $baseQuery)->where('trang_thai_don_hang', 'cho_giao_hang')->count(),
            'van_chuyen' => (clone $baseQuery)->where('trang_thai_don_hang', 'dang_giao')->count(),
            'hoan_thanh' => (clone $baseQuery)->where('trang_thai_don_hang', 'hoan_thanh')->count(),
            'da_huy' => (clone $baseQuery)->where('trang_thai_don_hang', 'da_huy')->count(),
            'tra_hang' => (clone $baseQuery)->whereIn('trang_thai_don_hang', ['tra_hang', 'hoan_tien'])->count(),
        ];

        return view('account.orders', [
            'orders' => $orders,
            'status' => $status,
            'orderCounts' => $orderCounts,
        ]);
    }

    /**
     * Cancel one of the authenticated user's orders.
     */
    public function cancelOrder(Request $request, $id)
    {
        $cancelReasons = [
            'Tôi muốn cập nhật địa chỉ/sđt nhận hàng.',
            'Tôi muốn thêm/thay đổi Mã giảm giá',
            'Tôi muốn thay đổi sản phẩm (kích thước, màu sắc, số lượng...)',
            'Thủ tục thanh toán rắc rối',
            'Tôi tìm thấy chỗ mua khác tốt hơn (Rẻ hơn, uy tín hơn, giao nhanh hơn...)',
            'Tôi không có nhu cầu mua nữa',
            'Tôi không tìm thấy lý do hủy phù hợp',
        ];

        $validated = $request->validate([
            'ly_do_huy' => ['required', 'string', Rule::in($cancelReasons)],
        ], [
            'ly_do_huy.required' => 'Vui lòng chọn lý do hủy đơn.',
            'ly_do_huy.in' => 'Lý do hủy đơn không hợp lệ.',
        ]);

        $order = DonHang::where('nguoi_dung_id', Auth::id())->findOrFail($id);

        if ($order->trang_thai_don_hang !== 'cho_xu_ly') {
            return back()->withErrors(['order' => 'Chỉ có thể hủy đơn hàng đang chờ xử lý.']);
        }

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'trang_thai_don_hang' => 'da_huy',
                'ly_do_huy' => $validated['ly_do_huy'],
            ]);
        });

        return redirect()->route('account.orders')->with('success', 'Đã hủy đơn hàng thành công.');
    }

    /**
     * Show the user's saved addresses
     */
    public function addresses()
    {
        $user = Auth::user();

        $addresses = Address::where('nguoi_dung_id', $user->id)
            ->orderByDesc('is_default')
            ->orderBy('id', 'asc')
            ->get();

        return view('account.addresses', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * Set a user's address as the default address
     */
    public function setDefaultAddress(Request $request, $id)
    {
        $user = Auth::user();

        $address = Address::where('nguoi_dung_id', $user->id)
            ->findOrFail($id);

        $address->setAsDefault();

        // If it's an AJAX request, return JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã cập nhật địa chỉ mặc định.']);
        }

        return redirect()->route('account.addresses')->with('success', 'Đã cập nhật địa chỉ mặc định.');
    }

    /**
     * Update the user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:nguoi_dung,email,' . $user->id . ',id',
            'so_dien_thoai' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('account.profile')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Change the user's password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->mat_khau_hash)) {
                    $fail('Mật khẩu hiện tại không đúng.');
                }
            }],
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user->update([
            'mat_khau_hash' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('account.profile')->with('success', 'Đổi mật khẩu thành công!');
    }
}
