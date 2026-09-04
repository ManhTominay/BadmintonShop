<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;
use App\Models\BienTheSanPham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Kiểm tra xem đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $request->validate([
            'bien_the_id' => 'nullable|integer',
            'so_luong' => 'required|integer|min:1',
            'size' => 'nullable|string|max:10',
            'cuoc_kem_bien_the_id' => 'nullable',
            'so_kg_cang' => 'nullable|numeric',
        ]);

        // Lấy ID người dùng thực tế đang đăng nhập (thay vì cố định là 1)
        $userId = Auth::id();

        $variant = BienTheSanPham::where('id', $request->bien_the_id)
            ->where('san_pham_id', $id)
            ->first();

        if (!$variant) {
            $variant = BienTheSanPham::where('san_pham_id', $id)->first();
        }

        if (!$variant) {
            $variant = new BienTheSanPham();
            $variant->san_pham_id = $id;
            $variant->size = $request->input('size');

            if (Schema::hasColumn('bien_the_san_pham', 'ma_sku')) {
                $variant->ma_sku = 'AUTO-' . $id;
            }

            if (Schema::hasColumn('bien_the_san_pham', 'so_luong_ton_kho')) {
                $variant->so_luong_ton_kho = 9999;
            } elseif (Schema::hasColumn('bien_the_san_pham', 'so_luong_ton')) {
                $variant->so_luong_ton = 9999;
            }

            $variant->save();
        }

        $variantId = $variant->id;
        $size = $request->input('size');

        $cartQuery = GioHang::where('nguoi_dung_id', $userId)
            ->where('bien_the_id', $variantId)
            ->where('cuoc_kem_bien_the_id', $request->cuoc_kem_bien_the_id)
            ->where('so_kg_cang', $request->so_kg_cang);

        if (Schema::hasColumn('gio_hang', 'size')) {
            $cartQuery->where('size', $size);
        }

        $cartItem = $cartQuery->first();

        if ($cartItem) {
            $cartItem->so_luong += $request->so_luong;
            $cartItem->save();
        } else {
            $data = [
                'nguoi_dung_id' => $userId,
                'bien_the_id' => $variantId,
                'so_luong' => $request->so_luong,
                'cuoc_kem_bien_the_id' => $request->cuoc_kem_bien_the_id,
                'so_kg_cang' => $request->so_kg_cang,
            ];

            if (Schema::hasColumn('gio_hang', 'size')) {
                $data['size'] = $size;
            }

            GioHang::create($data);
        }

        $message = 'Đã thêm sản phẩm vào giỏ hàng!';
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'cartCount' => GioHang::validCartCount($userId),
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        GioHang::cleanupInvalidItemsForUser($userId);

        $gioHangs = GioHang::where('nguoi_dung_id', $userId)->get();

        $cart = [];
        foreach ($gioHangs as $item) {
            $variant = $item->variant;
            $sanPham = $variant && $variant->sanPham ? $variant->sanPham : null;

            if (!$sanPham) {
                $item->delete();
                continue;
            }

            $cart[$item->id] = [
                'ten'      => $sanPham->ten_san_pham ?? $sanPham->ten ?? 'Sản phẩm cầu lông',
                'gia'      => $sanPham->gia_co_ban ?? $sanPham->gia ?? 0,
                'anh'      => $sanPham->anh_dai_dien ?? $sanPham->anh ?? 'yonex_doura10.webp',
                'size'     => $item->size ?: null,
                'so_luong' => $item->so_luong,
            ];
        }

        return view('cart', compact('cart'));
    }

    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['cartCount' => 0]);
        }

        $cartCount = GioHang::validCartCount(Auth::id());

        return response()->json(['cartCount' => $cartCount]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:1',
        ]);

        $cartItem = GioHang::find($id);
        
        // Đảm bảo chỉ user sở hữu giỏ hàng đó mới được quyền cập nhật
        if ($cartItem && $cartItem->nguoi_dung_id == Auth::id()) {
            $cartItem->so_luong = $request->so_luong;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Đã cập nhật số lượng giỏ hàng!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cartItem = GioHang::find($id);
        
        // Đảm bảo chỉ user sở hữu mới được xóa
        if ($cartItem && $cartItem->nguoi_dung_id == Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clearCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        GioHang::where('nguoi_dung_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!');
    }
    public function checkout(Request $request)
{
    // Lấy chuỗi items trên URL (ví dụ: ?items=9,12)
    $itemIds = $request->query('items');
    
    if (!$itemIds) {
        return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
    }

    $idsArray = explode(',', $itemIds);
    $cart = session()->get('cart', []);
    $checkoutItems = [];
    $totalPrice = 0;

    foreach ($idsArray as $id) {
        if (isset($cart[$id])) {
            $checkoutItems[$id] = $cart[$id];
            $totalPrice += $cart[$id]['gia'] * $cart[$id]['so_luong'];
        }
    }

    if (empty($checkoutItems)) {
        return redirect()->route('cart.index')->with('error', 'Không tìm thấy sản phẩm hợp lệ trong giỏ hàng!');
    }

    return view('checkout', compact('checkoutItems', 'totalPrice'));
}
}