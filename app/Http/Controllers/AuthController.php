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

        // Generate reset token
        $token = \Illuminate\Support\Str::random(60);
        
        // Store token in database
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        try {
            Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));
        } catch (\Throwable $e) {
            $resetUrl = url('/password-reset/' . $token . '?email=' . urlencode($user->email));
            \Illuminate\Support\Facades\Log::info('Password reset link generated for local testing', [
                'email' => $user->email,
                'reset_url' => $resetUrl,
            ]);

            session(['reset_email' => $user->email]);

            return redirect('/password-reset-sent')->with([
                'email' => $user->email,
                'reset_url' => $resetUrl,
            ]);
        }

        session(['reset_email' => $user->email]);

        return redirect('/password-reset-sent')->with('email', $user->email);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:nguoi_dung,email',
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Find the reset token record
        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['token' => 'Token không hợp lệ hoặc hết hạn.']);
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