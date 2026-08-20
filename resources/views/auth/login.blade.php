<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <span class="font-extrabold text-2xl text-slate-900 uppercase">BADMINTON <span class="text-orange-500">PRO</span></span>
            </a>
            <h2 class="text-gray-600 text-sm mt-2 font-medium">Đăng nhập tài khoản của bạn</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 text-xs p-3 rounded mb-4 border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-orange-500" placeholder="nhapemail@example.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mật khẩu</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-orange-500" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-orange-500 text-white font-bold py-2.5 rounded hover:bg-orange-600 transition text-sm uppercase">
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