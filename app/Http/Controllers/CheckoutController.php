<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private const SHOP_LAT = 21.0461067;
    private const SHOP_LNG = 105.7620995;

    private function haversineKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function getRegionBaseFee(?string $province): int
    {
        if (empty($province)) {
            return 50000;
        }

        $normalized = trim(mb_strtoupper($province, 'UTF-8'));

        $north = [
            'HÀ NỘI', 'HÀ GIANG', 'CAO BẰNG', 'LẠNG SƠN', 'BẮC KẠN', 'TUYÊN QUANG', 'THÁI NGUYÊN',
            'LÀO CAI', 'YÊN BÁI', 'SƠN LA', 'PHÚ THỌ', 'VINH PHÚC', 'BẮC GIANG', 'BẮC NINH',
            'HẢI DƯƠNG', 'HẢI PHÒNG', 'HƯNG YÊN', 'THÁI BÌNH', 'HÀ NAM', 'NAM ĐỊNH', 'NINH BÌNH',
            'THANH HÓA', 'NGHỆ AN', 'HÀ TĨNH'
        ];

        $central = [
            'QUẢNG BÌNH', 'QUẢNG TRỊ', 'THỪA THIÊN HUẾ', 'ĐÀ NẴNG', 'QUẢNG NAM', 'QUẢNG NGÃI',
            'BÌNH ĐỊNH', 'PHÚ YÊN', 'KHÁNH HÒA', 'NINH THUẬN', 'KON TUM', 'GIA LAI', 'ĐẮK LẮK',
            'ĐẮK NÔNG', 'LÂM ĐỒNG', 'BÌNH THUẬN'
        ];

        $south = [
            'TP. HỒ CHÍ MINH', 'HỒ CHÍ MINH', 'BÌNH DƯƠNG', 'BÌNH PHƯỚC', 'ĐỒNG NAI', 'BÀ RỊA - VŨNG TÀU',
            'BÀ RỊA VŨNG TÀU', 'LONG AN', 'TIỀN GIANG', 'BẾN TRE', 'TRÀ VINH', 'VĨNH LONG',
            'ĐỒNG THÁP', 'AN GIANG', 'KIÊN GIANG', 'CẦN THƠ', 'HẬU GIANG', 'SÓC TRĂNG', 'BẠC LIÊU',
            'CÀ MAU', 'TÂY NINH', 'NINH THUẬN', 'BÌNH THUẬN'
        ];

        foreach ($north as $item) {
            if ($normalized === $item || str_contains($normalized, $item)) {
                return 30000;
            }
        }

        foreach ($central as $item) {
            if ($normalized === $item || str_contains($normalized, $item)) {
                return 40000;
            }
        }

        foreach ($south as $item) {
            if ($normalized === $item || str_contains($normalized, $item)) {
                return 50000;
            }
        }

        return 50000;
    }

    private function calculateShippingFee(?float $lat, ?float $lng, ?string $province = null): array
    {
        $distanceKm = 0.0;
        $shippingFee = $this->getRegionBaseFee($province);

        if ($lat !== null && $lng !== null) {
            $distanceKm = $this->haversineKm(self::SHOP_LAT, self::SHOP_LNG, (float) $lat, (float) $lng);
        }

        return [
            'shipping_fee' => $shippingFee,
            'distance_km' => round($distanceKm, 1),
        ];
    }

    // Kiểm tra và điều hướng khi bấm thanh toán từ giỏ hàng
    public function index(Request $request)
    {
        $user = auth()->user();
        $address = Address::getDefaultForUser($user->id);

        $items = $request->query('items');

        if (!$address) {
            return redirect()->route('checkout.address', ['items' => $items]);
        }

        return redirect()->route('checkout.payment', ['items' => $items]);
    }

    public function showAddressForm(Request $request)
    {
        $address = Address::getDefaultForUser(auth()->id());

        return view('checkout-address', [
            'address' => $address,
            'isEdit' => false,
            'selectedItems' => $request->query('items'),
        ]);
    }

    public function editAddressForm(Request $request)
    {
        $address = $request->filled('address_id')
            ? Address::where('nguoi_dung_id', auth()->id())->find($request->integer('address_id'))
            : Address::getDefaultForUser(auth()->id());

        if (!$address) {
            return redirect()->route('checkout.address', ['items' => $request->query('items')]);
        }

        return view('checkout-address', [
            'address' => $address,
            'isEdit' => true,
            'selectedItems' => $request->query('items'),
        ]);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'tinh_thanh' => 'required|string|max:255',
            'phuong_xa' => 'required|string|max:255',
            'dia_chi_chi_tiet' => 'required|string|max:255',
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $address = Address::create([
            'nguoi_dung_id' => auth()->id(),
            'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
            'so_dien_thoai' => $request->so_dien_thoai,
            'tinh_thanh' => $request->tinh_thanh,
            'phuong_xa' => $request->phuong_xa,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'is_default' => !Address::where('nguoi_dung_id', auth()->id())->exists(),
        ]);

        if ($request->boolean('is_default') || !Address::where('nguoi_dung_id', auth()->id())->where('is_default', true)->exists()) {
            $address->setAsDefault();
        }

        $selectedItems = $request->input('items');

        return redirect()->route('checkout.payment', ['items' => $selectedItems]);
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'tinh_thanh' => 'required|string|max:255',
            'phuong_xa' => 'required|string|max:255',
            'dia_chi_chi_tiet' => 'required|string|max:255',
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $address = $request->filled('address_id')
            ? Address::where('nguoi_dung_id', auth()->id())->findOrFail($request->input('address_id'))
            : Address::create([
                'nguoi_dung_id' => auth()->id(),
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'so_dien_thoai' => $request->so_dien_thoai,
                'tinh_thanh' => $request->tinh_thanh,
                'phuong_xa' => $request->phuong_xa,
                'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'is_default' => false,
            ]);

        if ($request->filled('address_id')) {
            $address->update([
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'so_dien_thoai' => $request->so_dien_thoai,
                'tinh_thanh' => $request->tinh_thanh,
                'phuong_xa' => $request->phuong_xa,
                'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);
        }

        if ($request->boolean('is_default')) {
            $address->setAsDefault();
        }

        $selectedItems = $request->input('items');

        return redirect()->route('checkout.payment', ['items' => $selectedItems]);
    }

    public function showPaymentPage(Request $request)
    {
        $user = Auth::user();
        $addressId = $request->integer('address_id');
        $address = $addressId
            ? Address::where('nguoi_dung_id', $user->id)->findOrFail($addressId)
            : Address::getDefaultForUser($user->id);

        $selectedIds = $request->query('items');
        $ids = $selectedIds ? explode(',', $selectedIds) : [];
        $items = [];
        $subtotal = 0;
        $addresses = Address::where('nguoi_dung_id', $user->id)
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->get();

        if (!empty($ids)) {
            $cartItems = GioHang::where('nguoi_dung_id', $user->id)
                ->whereIn('id', $ids)
                ->get();

            foreach ($cartItems as $cartItem) {
                if ($cartItem->variant && $cartItem->variant->sanPham) {
                    $product = $cartItem->variant->sanPham;
                    $price = (float) ($product->gia_co_ban ?? $product->gia ?? 0);
                    $qty = (int) $cartItem->so_luong;
                    $lineTotal = $price * $qty;
                    $subtotal += $lineTotal;

                    $items[] = [
                        'id' => $cartItem->id,
                        'ten' => $product->ten_san_pham ?? 'Sản phẩm',
                        'anh' => $product->anh_dai_dien ?? 'default.png',
                        'gia' => $price,
                        'so_luong' => $qty,
                        'line_total' => $lineTotal,
                        'size' => $cartItem->size,
                    ];
                }
            }
        } else {
            $cartItems = GioHang::where('nguoi_dung_id', $user->id)->get();
            foreach ($cartItems as $cartItem) {
                if ($cartItem->variant && $cartItem->variant->sanPham) {
                    $product = $cartItem->variant->sanPham;
                    $price = (float) ($product->gia_co_ban ?? $product->gia ?? 0);
                    $qty = (int) $cartItem->so_luong;
                    $lineTotal = $price * $qty;
                    $subtotal += $lineTotal;

                    $items[] = [
                        'id' => $cartItem->id,
                        'ten' => $product->ten_san_pham ?? 'Sản phẩm',
                        'anh' => $product->anh_dai_dien ?? 'default.png',
                        'gia' => $price,
                        'so_luong' => $qty,
                        'line_total' => $lineTotal,
                        'size' => $cartItem->size,
                    ];
                }
            }
        }

        $shippingInfo = $this->calculateShippingFee($address?->lat, $address?->lng, $address?->tinh_thanh);
        $shippingFee = $shippingInfo['shipping_fee'];
        $distanceKm = $shippingInfo['distance_km'];
        $voucherCode = $request->query('voucher');
        $voucherOptions = [];

        foreach (VoucherService::definitions() as $code => $definition) {
            $status = VoucherService::getVoucherStatus($code);
            $voucherOptions[$code] = [
                'label' => $definition['label'],
                'type' => $definition['type'],
                'value' => $definition['value'],
                'enabled' => $status['enabled'],
                'remaining_uses' => $status['remaining_uses'],
                'expired' => $status['expired'],
            ];
        }

        $selectedVoucher = null;
        $voucher = 0;

        if ($voucherCode && isset($voucherOptions[$voucherCode]) && $voucherOptions[$voucherCode]['enabled']) {
            $selectedVoucher = $voucherOptions[$voucherCode];

            $discountResult = VoucherService::computeDiscount($voucherCode, $subtotal, $shippingFee);
            $shippingFee = $discountResult['shipping_fee'];
            $voucher = $discountResult['discount'];

            $voucherOptions[$voucherCode]['remaining_uses'] = VoucherService::getVoucherStatus($voucherCode)['remaining_uses'];
        } else {
            $voucherCode = null;
        }

        $finalTotal = max(0, $subtotal + $shippingFee - $voucher);

        return view('checkout', compact('address', 'addresses', 'items', 'subtotal', 'shippingFee', 'voucher', 'finalTotal', 'voucherCode', 'voucherOptions', 'selectedVoucher', 'distanceKm'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'items' => 'nullable|string',
            'address_id' => 'required|integer',
            'payment_method' => 'required|in:VietQR,CashOnDelivery',
            'shipping_fee' => 'required|numeric|min:0',
            'voucher_code' => 'nullable|string|max:50',
        ]);

        $address = Address::where('nguoi_dung_id', $user->id)->findOrFail($validated['address_id']);
        $itemIds = collect(explode(',', (string) ($validated['items'] ?? '')))
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->values();

        $cartQuery = GioHang::where('nguoi_dung_id', $user->id)->with(['variant.sanPham']);
        if ($itemIds->isNotEmpty()) {
            $cartQuery->whereIn('id', $itemIds);
        }

        $cartItems = $cartQuery->get()->filter(fn ($item) => $item->variant?->sanPham);
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Giỏ hàng không có sản phẩm.'], 422);
        }

        $subtotal = $cartItems->sum(function ($cartItem) {
            $price = (float) ($cartItem->variant->sanPham->gia_co_ban ?? $cartItem->variant->sanPham->gia ?? 0);
            return $price * (int) $cartItem->so_luong;
        });
        $shippingFee = (float) $validated['shipping_fee'];
        $discount = 0;

        if (!empty($validated['voucher_code'])) {
            $discountResult = VoucherService::computeDiscount($validated['voucher_code'], $subtotal, $shippingFee);
            $shippingFee = $discountResult['shipping_fee'];
            $discount = $discountResult['discount'];
        }

        $order = DB::transaction(function () use ($user, $address, $cartItems, $subtotal, $shippingFee, $discount, $validated) {
            $paymentMethod = $validated['payment_method'];
            $order = DonHang::create([
                'ma_don_hang' => 'DH' . now()->format('YmdHis') . random_int(100, 999),
                'nguoi_dung_id' => $user->id,
                'ten_nguoi_nhan' => $address->ten_nguoi_nhan,
                'so_dien_thoai' => $address->so_dien_thoai,
                'dia_chi_giao_hang' => implode(', ', array_filter([$address->dia_chi_chi_tiet, $address->phuong_xa, $address->tinh_thanh])),
                'tong_tien_hang' => $subtotal,
                'phi_van_chuyen' => $shippingFee,
                'so_tien_giam' => $discount,
                'tong_thanh_toan' => max(0, $subtotal + $shippingFee - $discount),
                'phuong_thuc_thanh_toan' => $paymentMethod,
                'trang_thai_thanh_toan' => 'cho_thanh_toan',
                'qr_expires_at' => $paymentMethod === 'VietQR' ? now()->addMinutes(10) : null,
                'trang_thai_don_hang' => 'cho_xu_ly',
                'ngay_tao' => now(),
            ]);

            foreach ($cartItems as $cartItem) {
                $price = (float) ($cartItem->variant->sanPham->gia_co_ban ?? $cartItem->variant->sanPham->gia ?? 0);
                DB::table('chi_tiet_don_hang')->insert([
                    'don_hang_id' => $order->id,
                    'san_pham_id' => $cartItem->variant->san_pham_id,
                    'bien_the_id' => $cartItem->bien_the_id,
                    'so_luong' => $cartItem->so_luong,
                    'gia' => $price,
                    'thanh_tien' => $price * $cartItem->so_luong,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            GioHang::whereIn('id', $cartItems->pluck('id'))->delete();

            return $order;
        });

        return response()->json([
            'redirect' => $order->phuong_thuc_thanh_toan === 'VietQR'
                ? route('payment.vietqr', $order)
                : route('account.orders'),
            'order_id' => $order->id,
        ]);
    }

    public function showVietQr(DonHang $order)
    {
        abort_unless($order->nguoi_dung_id === Auth::id(), 403);

        return view('payment.vietqr', compact('order'));
    }
}