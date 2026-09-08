<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng - BADMINTON PRO SHOP</title>
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
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Đơn hàng của tôi</h1>
            <p class="text-gray-600">Xem chi tiết các đơn hàng đã đặt</p>
        </div>

        <!-- Danh sách đơn hàng -->
    @if ($orders->count() > 0)
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <!-- Thông tin đơn hàng -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fa-solid fa-box text-orange-500 mr-2"></i>
                                Đơn hàng #{{ $order->ma_don_hang ?? $order->id }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fa-solid fa-calendar mr-1"></i>
                                {{ $order->ngay_tao ? date('d/m/Y H:i', strtotime($order->ngay_tao)) : 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-orange-500">
                                {{ number_format($order->tong_thanh_toan ?? $order->tong_tien_hang, 0, ',', '.') }} ₫
                            </p>
                            <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full
                                @if ($order->trang_thai_don_hang === 'hoan_thanh') bg-green-100 text-green-700
                                @elseif ($order->trang_thai_don_hang === 'cho_xu_ly') bg-blue-100 text-blue-700
                                @elseif ($order->trang_thai_don_hang === 'da_huy') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif
                            ">
                                @switch($order->trang_thai_don_hang)
                                    @case('hoan_thanh')
                                        <i class="fa-solid fa-check-circle mr-1"></i>Hoàn thành
                                    @break
                                    @case('cho_xu_ly')
                                        <i class="fa-solid fa-hourglass-half mr-1"></i>Chờ xử lý
                                    @break
                                    @case('dang_giao')
                                        <i class="fa-solid fa-truck mr-1"></i>Đang giao
                                    @break
                                    @case('da_huy')
                                        <i class="fa-solid fa-times-circle mr-1"></i>Đã hủy
                                    @break
                                    @default
                                        <i class="fa-solid fa-info-circle mr-1"></i>Chờ xử lý
                                @endswitch
                            </span>
                        </div>
                    </div>

                    <!-- Thông tin giao hàng -->
                    <div class="bg-gray-50 rounded p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 font-semibold">Người nhận</p>
                                <p class="text-gray-800">{{ $order->ten_nguoi_nhan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-semibold">Điện thoại</p>
                                <p class="text-gray-800">{{ $order->so_dien_thoai ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-gray-500 font-semibold">Địa chỉ giao hàng</p>
                                <p class="text-gray-800">{{ $order->dia_chi_giao_hang ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin thanh toán -->
                    <div class="border-t pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 font-semibold">Tổng hàng</p>
                                <p class="text-gray-800">{{ number_format($order->tong_tien_hang ?? 0, 0, ',', '.') }} ₫</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-semibold">Phí vận chuyển</p>
                                <p class="text-gray-800">{{ number_format($order->phi_van_chuyen ?? 0, 0, ',', '.') }} ₫</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-semibold">Phương thức thanh toán</p>
                                <p class="text-gray-800">
                                    @if ($order->phuong_thuc_thanh_toan === 'VietQR')
                                        <i class="fa-solid fa-qrcode mr-1"></i>VietQR
                                    @elseif ($order->phuong_thuc_thanh_toan === 'cod')
                                        <i class="fa-solid fa-money-bill mr-1"></i>Thanh toán khi nhận hàng
                                    @elseif ($order->phuong_thuc_thanh_toan === 'transfer')
                                        <i class="fa-solid fa-bank mr-1"></i>Chuyển khoản ngân hàng
                                    @else
                                        {{ $order->phuong_thuc_thanh_toan ?? 'N/A' }}
                                    @endif
                                </p>
                                @if ($order->phuong_thuc_thanh_toan === 'VietQR')
                                    <p class="mt-1 font-semibold {{ $order->trang_thai_thanh_toan === 'da_thanh_toan' ? 'text-emerald-600' : 'text-amber-600' }}">
                                        {{ $order->trang_thai_thanh_toan === 'da_thanh_toan' ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($order->phuong_thuc_thanh_toan === 'VietQR' && $order->trang_thai_thanh_toan !== 'da_thanh_toan' && $order->qr_expires_at && $order->qr_expires_at->isFuture() && config('services.sepay.bank_code') && config('services.sepay.account_number'))
                        @php
                            $qrInfo = urlencode($order->ma_don_hang ?? 'DH' . $order->id);
                            $qrAccountName = urlencode(config('services.sepay.account_name', ''));
                            $qrUrl = 'https://img.vietqr.io/image/' . config('services.sepay.bank_code') . '-' . config('services.sepay.account_number') . '-compact2.png?amount=' . (int) ($order->tong_thanh_toan ?? 0) . '&addInfo=' . $qrInfo . '&accountName=' . $qrAccountName;
                        @endphp
                        <div class="mt-4 flex flex-col items-center gap-3 rounded-lg border border-orange-200 bg-orange-50 p-4 text-center md:flex-row md:text-left">
                            <img src="{{ $qrUrl }}" alt="Mã QR thanh toán đơn hàng" class="h-44 w-44 rounded bg-white p-2">
                            <div class="text-sm text-gray-700">
                                <p class="font-bold text-orange-700">Đang chờ thanh toán VietQR</p>
                                <p class="mt-1">Quét mã bằng ứng dụng ngân hàng và nhập đúng số tiền.</p>
                                <p class="mt-1">Nội dung: <strong>{{ $order->ma_don_hang }}</strong></p>
                                <p class="mt-1 text-xs text-gray-500">Hệ thống sẽ tự cập nhật khi SePay nhận được giao dịch.</p>
                            </div>
                        </div>
                    @elseif ($order->phuong_thuc_thanh_toan === 'VietQR')
                        <div class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
                            Trạng thái thanh toán: {{ $order->trang_thai_thanh_toan === 'da_thanh_toan' ? 'Đã thanh toán' : 'Chờ thanh toán' }}.
                        </div>
                    @endif

                    <!-- Nút hành động -->
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('san-pham.chi-tiet', 1) }}" class="text-orange-500 hover:text-orange-600 font-semibold text-sm">
                            <i class="fa-solid fa-eye mr-1"></i>Xem chi tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links('pagination::tailwind') }}
            </div>
        @endif
    @else
        <!-- Trống -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-12 text-center">
            <div class="mb-4">
                <i class="fa-solid fa-inbox text-6xl text-gray-300"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Chưa có đơn hàng</h2>
            <p class="text-gray-500 mb-6">Bạn chưa tạo bất kỳ đơn hàng nào. Hãy mua sắm ngay!</p>
            <a href="{{ route('home') }}" class="inline-block bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-orange-600 transition">
                <i class="fa-solid fa-shopping-bag mr-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    @endif

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
