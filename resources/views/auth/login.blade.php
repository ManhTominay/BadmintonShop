<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - BADMINTON PRO SHOP</title>
    <base href="{{ asset('/') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased text-gray-800">

    <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center px-4" 
     style="background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.85)), url('{{ asset('images/banner_login.jfif') }}');">
        
        <!-- Hiệu ứng trang trí ánh sáng nền nhẹ -->
        <div class="absolute inset-0 bg-gradient-to-tr from-orange-600/20 to-transparent pointer-events-none"></div>

        <!-- Khung Form Đăng Nhập -->
        <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            
            <!-- Logo / Tiêu đề -->
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 group mb-2">
                    <i class="fa-solid fa-shuttlecock text-3xl text-orange-500 group-hover:rotate-12 transition-transform duration-300"></i>
                    <div class="leading-none text-left">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</span>
                        <span class="block font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</span>
                    </div>
                </a>
                <p class="text-xs text-gray-500 font-medium">Đăng nhập tài khoản quản lý và mua sắm của bạn</p>
            </div>

            <!-- Hiển thị thông báo lỗi nếu có -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-600 text-xs rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Form đăng nhập chính -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-9 pr-3 py-2.5 text-xs bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition"
                               placeholder="nhập email của bạn...">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase">Mật khẩu</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] text-orange-500 hover:underline font-medium">Quên mật khẩu?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" required
                               class="w-full pl-9 pr-3 py-2.5 text-xs bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center text-xs">
                    <label class="flex items-center text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-500 focus:ring-orange-400 mr-2">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <button type="hidden" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs uppercase py-3 rounded-lg shadow-lg shadow-orange-500/30 transition-all duration-200">
                    Đăng Nhập
                </button>
            </form>

            <!-- Chuyển hướng đăng ký -->
            <div class="mt-6 text-center text-xs text-gray-500 border-t border-gray-100 pt-4">
                Chưa có tài khoản? <a href="{{ route('register') }}" class="text-orange-500 font-bold hover:underline">Đăng ký ngay</a>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-[11px] text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại trang chủ cửa hàng
                </a>
            </div>

        </div>
    </div>

</body>
</html>