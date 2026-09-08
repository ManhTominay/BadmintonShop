<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cần truyền 'password' cho Auth::attempt để Laravel tự gọi hàm getAuthPassword() trong Model User
        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            // KIỂM TRA QUYỀN: Nếu là admin thì chuyển hướng thẳng vào dashboard
            if (Auth::user()->vai_tro === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Nếu là khách hàng bình thường thì về trang chủ
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:nguoi_dung,email',
            'so_dien_thoai' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Sử dụng trực tiếp class namespace đầy đủ để đảm bảo gọi đúng Model
        $user = \App\Models\User::create([
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'mat_khau_hash' => Hash::make($request->password),
            'vai_tro' => 'khach_hang',
        ]);

        VoucherService::grantWelcomeVoucher();
        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Forgot Password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:nguoi_dung,email',
        ], [
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại.']);
        }

        // Generate a short-lived one-time password.
        $otp = (string) random_int(100000, 999999);
        
        // Store token in database
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]
        );

        try {
            Mail::to($user->email)->send(new ResetPasswordMail($otp, $user->email));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Could not send password reset OTP email.', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['email' => 'Không thể gửi mã OTP. Vui lòng kiểm tra cấu hình Gmail và thử lại.']);
        }

        session(['reset_email' => $user->email]);

        return redirect('/password-reset-sent')->with('email', $user->email);
    }

    public function showResetPasswordForm($token = null)
    {
        return view('auth.reset-password', [
            'email' => session('reset_email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:nguoi_dung,email',
            'otp' => ['required', 'digits:6'],
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Find the reset token record
        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord
            || !$resetRecord->created_at
            || now()->greaterThan(\Carbon\Carbon::parse($resetRecord->created_at)->addMinutes(10))
            || !Hash::check($request->otp, $resetRecord->token)) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'mat_khau_hash' => Hash::make($request->password),
        ]);

        // Delete the token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success', 'Mật khẩu của bạn đã được cập nhật. Hãy đăng nhập.');
    }

    public function showResetSentPage()
    {
        return view('auth.reset-password-sent');
    }
}