<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Nhớ đảm bảo có dòng use Auth này

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Kiểm tra xem đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $request->validate([
            'bien_the_id' => 'required',
            'so_luong' => 'required|integer|min:1',
            'cuoc_kem_bien_the_id' => 'nullable',
            'so_kg_cang' => 'nullable|numeric',
        ]);

        // Lấy ID người dùng thực tế đang đăng nhập (thay vì cố định là 1)
        $userId = Auth::id();

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

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Lấy ID người dùng đang đăng nhập
        $userId = Auth::id();

        // Lấy danh sách giỏ hàng từ database theo đúng user đang đăng nhập
        $gioHangs = GioHang::where('nguoi_dung_id', $userId)->get();

        $cart = [];
        foreach ($gioHangs as $item) {
            // Truy vấn trực tiếp bảng san_pham dựa vào bien_the_id
            $sanPham = DB::table('san_pham')->where('id', $item->bien_the_id)->first();

            $cart[$item->id] = [
                'ten'      => $sanPham->ten ?? $sanPham->ten_san_pham ?? 'Sản phẩm cầu lông',
                'gia'      => $sanPham->gia ?? $sanPham->gia_co_ban ?? 0,
                'anh'      => $sanPham->anh ?? $sanPham->anh_dai_dien ?? 'yonex_doura10.webp',
                'so_luong' => $item->so_luong,
            ];
        }

        return view('cart', compact('cart'));
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