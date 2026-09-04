<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản - BADMINTON PRO SHOP</title>
    <base href="{{ asset('/') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Top Bar -->
    <div class="bg-slate-900 text-white text-xs py-1 text-center font-medium">
        Badminton Essential Equipment
    </div>

    <!-- Header Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="block">
                    <span class="text-2xl font-extrabold tracking-wider text-slate-900">BADMINTON</span>
                    <span class="block text-xs font-bold tracking-widest text-orange-500 uppercase">PRO SHOP</span>
                </a>
            </div>

            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ route('product.search') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    <div class="relative flex items-center flex-1 px-4 py-2">
                        <span class="absolute left-4 text-gray-400 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm sản phẩm..." 
                               class="w-full text-sm text-gray-700 bg-transparent pl-7 pr-2 focus:outline-none placeholder-gray-400" autocomplete="off">
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2.5 text-sm transition duration-150">Tìm kiếm</button>
                </form>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative group">
                        <button type="button" class="text-gray-600 hover:text-orange-500 transition" title="Tài khoản">
                            <i class="fa-regular fa-user text-xl"></i>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-52 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="px-3 py-2 border-b border-gray-100 text-xs font-bold text-slate-700">
                                Xin chào, <span class="text-orange-500">{{ Auth::user()->ho_ten ?? Auth::user()->full_name ?? Auth::user()->name ?? Auth::user()->username }}</span>
                            </div>
                            <a href="{{ route('account.profile') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fa-solid fa-user-pen text-[11px]"></i> Chỉnh sửa tài khoản
                            </a>
                            <a href="{{ route('account.orders') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fa-solid fa-box-open text-[11px]"></i> Đơn hàng
                            </a>
                            <a href="{{ route('account.addresses') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fa-solid fa-location-dot text-[11px]"></i> Địa chỉ của tôi
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 border-t border-gray-100">
                                    <i class="fa-solid fa-right-from-bracket text-[11px]"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 transition py-1 px-1">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-3 py-1.5 rounded hover:bg-orange-600 transition shadow-sm">Đăng ký</a>
                @endauth
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php if (!isset($cartCount)) { $cartCount = Auth::check() ? \App\Models\GioHang::where('nguoi_dung_id', Auth::id())->sum('so_luong') : 0; } @endphp
                    <span data-cart-count class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount }}</span>
                </a>
            </div>
        </div>

        <nav class="border-t border-gray-100 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-3 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ url('/') }}" class="hover:text-orange-500 transition">Trang chủ</a></li>
                    <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition">Vợt</a></li>
                    <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition">Giày</a></li>
                    <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition">Quần áo</a></li>
                    <li><a href="{{ url('/cau') }}" class="hover:text-orange-500 transition">Cầu</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">Phụ kiện</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Chỉnh sửa tài khoản</h1>
            <p class="text-gray-600">Quản lý thông tin cá nhân của bạn</p>
        </div>

        <!-- Form chỉnh sửa -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('account.update-profile') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Họ và tên -->
                <div class="mb-6">
                    <label for="ho_ten" class="block text-sm font-semibold text-gray-700 mb-2">
                        Họ và tên <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="ho_ten"
                        name="ho_ten"
                        value="{{ old('ho_ten', $user->ho_ten) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('ho_ten') border-red-500 @enderror"
                        required
                    />
                    @error('ho_ten')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror"
                        required
                    />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="mb-6">
                    <label for="so_dien_thoai" class="block text-sm font-semibold text-gray-700 mb-2">
                        Số điện thoại
                    </label>
                    <input
                        type="tel"
                        id="so_dien_thoai"
                        name="so_dien_thoai"
                        value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('so_dien_thoai') border-red-500 @enderror"
                    />
                    @error('so_dien_thoai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nút hành động -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-600 transition"
                    >
                        <i class="fa-solid fa-save mr-2"></i>Lưu thay đổi
                    </button>
                    <a
                        href="{{ route('home') }}"
                        class="flex-1 bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400 transition text-center"
                    >
                        <i class="fa-solid fa-xmark mr-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Đổi mật khẩu -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Đổi mật khẩu</h2>

            <form action="{{ route('account.update-password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Mật khẩu hiện tại <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('current_password') border-red-500 @enderror"
                        required
                    />
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Mật khẩu mới <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('new_password') border-red-500 @enderror"
                        required
                    />
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required
                    />
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-600 transition"
                    >
                        <i class="fa-solid fa-key mr-2"></i>Đổi mật khẩu
                    </button>
                    <a
                        href="{{ route('account.profile') }}"
                        class="flex-1 bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400 transition text-center"
                    >
                        <i class="fa-solid fa-xmark mr-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Link quay lại -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                <i class="fa-solid fa-arrow-left mr-2"></i>Quay lại trang chủ
            </a>
        </div>
    </main>

    <footer class="bg-slate-900 text-white py-8 mt-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">BADMINTON PRO SHOP</h3>
                    <p class="text-gray-400 text-sm">Cung cấp thiết bị cầu lông chính hãng, chất lượng cao.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Danh mục</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/vot-cau-long" class="hover:text-orange-500 transition">Vợt</a></li>
                        <li><a href="/giay-cau-long" class="hover:text-orange-500 transition">Giày</a></li>
                        <li><a href="/quan-ao" class="hover:text-orange-500 transition">Quần áo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-orange-500 transition">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Chính sách</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Liên hệ</h4>
                    <p class="text-sm text-gray-400">Email: info@badmintonshop.com</p>
                    <p class="text-sm text-gray-400">SĐT: 0123-456-789</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2024 BADMINTON PRO SHOP. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
