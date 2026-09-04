<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .login-shell {
            background: #f3f3f3;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #f9f9f9;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }
        .brand-word {
            font-weight: 900;
            letter-spacing: 0.5px;
        }
        .field-label {
            font-size: 12px;
            letter-spacing: 0.08em;
            color: #4b5563;
            font-weight: 800;
        }
        .form-input {
            border: 1px solid #dfe7ef;
            background: #edf3f8;
            border-radius: 6px;
            height: 42px;
            padding: 0 12px;
            font-size: 14px;
            color: #1f2937;
        }
        .form-input:focus {
            outline: none;
            border-color: #d1d9e2;
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.08);
        }
        .submit-btn {
            background: linear-gradient(180deg, #ff9d2f 0%, #f57b00 100%);
            box-shadow: 0 2px 0 rgba(0,0,0,0.08);
        }
        .submit-btn:hover {
            filter: brightness(0.98);
        }
    </style>
</head>
<body class="login-shell min-h-screen flex items-center justify-center px-4">
    <div class="login-card p-7 sm:p-8">
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="inline-block">
                <div class="brand-word text-3xl text-slate-900 uppercase leading-none">
                    BADMINTON <span class="text-orange-500">PRO</span>
                </div>
            </a>
            <h2 class="text-gray-600 text-sm mt-3 font-medium">Đăng nhập tài khoản của bạn</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 text-xs p-3 rounded mb-4 border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="field-label block mb-2 uppercase">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="form-input w-full" placeholder="tan@gmail.com">
            </div>

            <div>
                <label class="field-label block mb-2 uppercase">Mật khẩu</label>
                <input type="password" name="password" required class="form-input w-full" placeholder="••••••••">
            </div>

            <div class="text-right mt-1">
                <a href="{{ route('password.request') }}" class="text-xs text-orange-500 hover:text-orange-600 font-semibold">
                    Quên mật khẩu?
                </a>
            </div>

            <button type="submit" class="submit-btn w-full text-white font-bold py-3 rounded text-sm uppercase transition">
                Đăng nhập
            </button>
        </form>

        <p class="text-center text-xs text-gray-600 mt-6">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="text-orange-500 font-bold hover:underline">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>