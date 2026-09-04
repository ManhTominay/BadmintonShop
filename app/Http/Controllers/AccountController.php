<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function orders()
    {
        $user = Auth::user();
        
        $orders = DonHang::where('nguoi_dung_id', $user->id)
            ->orderBy('ngay_tao', 'desc')
            ->paginate(10);
        
        return view('account.orders', [
            'orders' => $orders,
        ]);
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
