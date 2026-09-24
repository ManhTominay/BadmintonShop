<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Models\Address;
use App\Models\DanhGia;
use App\Models\DonHang;
use App\Models\GioHang;

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
            ->with([
                'chiTietDonHangs.sanPham',
                'chiTietDonHangs.bienThe',
                'danhGias' => fn ($query) => $query->where('nguoi_dung_id', $user->id),
            ]);
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

        $wasPaid = $order->trang_thai_thanh_toan === 'da_thanh_toan';

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'trang_thai_don_hang' => $order->trang_thai_thanh_toan === 'da_thanh_toan'
                    ? 'tra_hang'
                    : 'da_huy',
                'ly_do_huy' => $validated['ly_do_huy'],
            ]);
        });

        $message = $wasPaid
            ? 'Đã hủy đơn hàng. Đơn hàng đã được chuyển sang mục Trả hàng/Hoàn tiền.'
            : 'Đã hủy đơn hàng thành công.';

        return redirect()->route('account.orders', [
            'status' => $wasPaid ? 'tra_hang' : 'da_huy',
        ])->with('success', $message);
    }

    /**
     * Permanently remove one of the authenticated user's finished orders.
     */
    public function deleteOrder($id)
    {
        $order = DonHang::where('nguoi_dung_id', Auth::id())->findOrFail($id);

        if (!in_array($order->trang_thai_don_hang, ['da_huy', 'hoan_thanh'], true)) {
            return back()->withErrors(['order' => 'Chỉ có thể xóa đơn hàng đã hủy hoặc hoàn thành.']);
        }

        DB::transaction(function () use ($order) {
            $order->chiTietDonHangs()->delete();
            $order->delete();
        });

        return redirect()->route('account.orders', [
            'status' => $order->trang_thai_don_hang === 'hoan_thanh' ? 'hoan_thanh' : 'da_huy',
        ])
            ->with('success', 'Đã xóa đơn hàng khỏi lịch sử.');
    }

    /**
     * Add the products from a cancelled order back to the cart.
     */
    public function reorder($id)
    {
        $order = DonHang::where('nguoi_dung_id', Auth::id())
            ->with('chiTietDonHangs.bienThe')
            ->findOrFail($id);

        if (!in_array($order->trang_thai_don_hang, ['da_huy', 'hoan_thanh'], true)) {
            return back()->withErrors(['order' => 'Chỉ có thể mua lại đơn hàng đã hủy hoặc hoàn thành.']);
        }

        $reorderItems = $order->chiTietDonHangs
            ->filter(fn ($item) => $item->bienThe && $item->bienThe->san_pham_id)
            ->mapWithKeys(fn ($item) => [$item->bienThe->id => (int) $item->so_luong])
            ->all();

        if (empty($reorderItems)) {
            return back()->withErrors(['order' => 'Các sản phẩm trong đơn không còn khả dụng.']);
        }

        session(['reorder_items' => $reorderItems]);

        return redirect()->route('checkout', [
            'return_to_orders' => 1,
            'order_status' => $order->trang_thai_don_hang === 'hoan_thanh' ? 'hoan_thanh' : 'da_huy',
            'reorder' => 1,
        ])
            ->with('success', 'Đã tải lại sản phẩm vào trang thanh toán.');
    }

    /**
     * Confirm that the authenticated user received an order.
     */
    public function confirmOrderReceived($id)
    {
        $order = DonHang::where('nguoi_dung_id', Auth::id())->findOrFail($id);

        if (!in_array($order->trang_thai_don_hang, ['cho_giao_hang', 'dang_giao'], true)) {
            return back()->withErrors(['order' => 'Chỉ có thể xác nhận khi đơn hàng đang được giao.']);
        }

        $order->update([
            'trang_thai_don_hang' => 'hoan_thanh',
        ]);

        return redirect()->route('account.orders', ['status' => 'hoan_thanh'])
            ->with('success', 'Đã xác nhận nhận hàng thành công.');
    }

    /**
     * Store or update a review for a product from a completed order.
     */
    public function reviewOrderProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'san_pham_id' => ['required', 'integer'],
            'so_sao' => ['required', 'integer', 'between:1,5'],
            'noi_dung' => ['nullable', 'string', 'max:1000'],
        ], [
            'so_sao.required' => 'Vui lòng chọn số sao đánh giá.',
            'so_sao.between' => 'Số sao đánh giá phải từ 1 đến 5.',
            'noi_dung.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ]);

        $order = DonHang::where('nguoi_dung_id', Auth::id())->findOrFail($id);

        if ($order->trang_thai_don_hang !== 'hoan_thanh') {
            return back()->withErrors(['review' => 'Chỉ có thể đánh giá đơn hàng đã hoàn thành.']);
        }

        $hasProduct = $order->chiTietDonHangs()
            ->where('san_pham_id', $validated['san_pham_id'])
            ->exists();

        if (!$hasProduct) {
            return back()->withErrors(['review' => 'Sản phẩm không thuộc đơn hàng này.']);
        }

        DanhGia::updateOrCreate(
            [
                'nguoi_dung_id' => Auth::id(),
                'don_hang_id' => $order->id,
                'san_pham_id' => $validated['san_pham_id'],
            ],
            [
                'so_sao' => $validated['so_sao'],
                'noi_dung' => $validated['noi_dung'] ?? null,
            ]
        );

        return redirect()->route('account.orders', ['status' => 'hoan_thanh'])
            ->with('success', 'Đã gửi đánh giá sản phẩm.');
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
