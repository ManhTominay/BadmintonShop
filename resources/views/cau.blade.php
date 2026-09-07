<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CẦU CẦU LÔNG - BADMINTON PRO SHOP</title>
    <!-- Thẻ base định vị chuẩn đường dẫn tĩnh -->
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
            
            <!-- Logo Shop -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <div class="leading-none">
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</h1>
                    <p class="font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</p>
                </div>
            </a>

            <!-- Thanh tìm kiếm kiểu dáng mới ở Header -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ route('cau') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    <div class="flex items-center flex-1 px-3 py-1.5">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2 text-sm"></i>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm sản phẩm..." 
                               class="w-full text-xs text-gray-700 bg-transparent focus:outline-none placeholder-gray-400"
                               autocomplete="off">
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-4 py-2 text-xs transition duration-150">
                        Tìm kiếm
                    </button>
                </form>
            </div>

            <!-- Giỏ hàng & Tài khoản -->
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

                <!-- Giỏ hàng hiển thị số lượng tự động -->
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php
                        if (!isset($cartCount)) {
                            $cartCount = Auth::check() 
                                ? \App\Models\GioHang::where('nguoi_dung_id', Auth::id())->sum('so_luong') 
                                : (session('cart') ? count(session('cart')) : 0);
                        }
                    @endphp
                    <span data-cart-count class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                </a>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-2 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'hover:text-orange-500 transition' }}">TRANG CHỦ</a></li>
                    <li><a href="{{ route('vot-cau-long') }}" class="{{ request()->is('vot-cau-long*') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'hover:text-orange-500 transition' }}">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ route('giay.index') }}" class="{{ request()->is('giay-cau-long*') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'hover:text-orange-500 transition' }}">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ route('quan-ao') }}" class="{{ request()->is('quan-ao*') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'hover:text-orange-500 transition' }}">QUẦN ÁO</a></li>
                    <li><a href="{{ route('cau') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1">CẦU</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 uppercase">CẦU CẦU LÔNG</h1>
                <p class="text-xs text-gray-500 mt-1">
                    Hiển thị {{ $danhSachCau instanceof \Illuminate\Pagination\LengthAwarePaginator ? $danhSachCau->total() : $danhSachCau->count() }} sản phẩm
                </p>
            </div>

            <!-- Bộ lọc Sắp xếp -->
            <form action="{{ route('cau') }}" method="GET" class="flex items-center gap-2">
                @if(request('keyword'))
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @endif
                <label class="text-xs font-semibold text-gray-600 whitespace-nowrap">Sắp xếp:</label>
                <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-2 text-xs bg-white focus:outline-none focus:border-orange-500 cursor-pointer">
                    <option value="">Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                </select>
            </form>
        </div>

        <!-- Thương hiệu phổ biến -->
        <div class="flex flex-wrap gap-2 mb-8">
            <span class="text-xs font-bold text-gray-500 self-center mr-2">Thương hiệu:</span>
            <a href="{{ route('cau', ['keyword' => 'Yonex']) }}" class="text-xs border rounded-full px-3 py-1 hover:border-orange-500 hover:text-orange-500 transition {{ request('keyword') == 'Yonex' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white' }}">Yonex</a>
            <a href="{{ route('cau', ['keyword' => 'Victor']) }}" class="text-xs border rounded-full px-3 py-1 hover:border-orange-500 hover:text-orange-500 transition {{ request('keyword') == 'Victor' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white' }}">Victor</a>
            <a href="{{ route('cau', ['keyword' => 'Lining']) }}" class="text-xs border rounded-full px-3 py-1 hover:border-orange-500 hover:text-orange-500 transition {{ request('keyword') == 'Lining' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white' }}">Lining</a>
            <a href="{{ route('cau', ['keyword' => 'Thành Công']) }}" class="text-xs border rounded-full px-3 py-1 hover:border-orange-500 hover:text-orange-500 transition {{ request('keyword') == 'Thành Công' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white' }}">Thành Công</a>
            @if(request('keyword'))
                <a href="{{ route('cau') }}" class="text-xs text-red-500 hover:underline self-center ml-2">Xóa bộ lọc</a>
            @endif
        </div>

        <!-- Grid Danh sách Cầu -->
        @if($danhSachCau->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($danhSachCau as $sp)
                <div class="group bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between hover:border-orange-500 hover:shadow-lg transition-all duration-300">
                    <div>
                        <!-- Khung ảnh sản phẩm -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->slug ?? $sp->id) }}" class="block h-44 bg-gray-50 rounded-lg flex items-center justify-center mb-3 p-2 overflow-hidden">
                            @php
                                $imageName = \App\Models\SanPham::resolveImageName($sp->anh_dai_dien ?? null);
                            @endphp
                            @if(!empty($imageName) && file_exists(public_path('images/' . $imageName)))
                                <img src="{{ asset('images/' . $imageName) }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            @else
                                <i class="fa-solid fa-shuttlecock text-5xl text-gray-300"></i>
                            @endif
                        </a>

                        <!-- Nút XEM CHI TIẾT -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->slug ?? $sp->id) }}" 
                           class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center font-bold text-xs uppercase py-2.5 rounded-lg transition-colors shadow mb-3">
                            XEM CHI TIẾT
                        </a>

                        <!-- Tên sản phẩm -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->slug ?? $sp->id) }}">
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug mb-2 hover:text-orange-500 transition-colors">
                                {{ $sp->ten_san_pham }}
                            </h3>
                        </a>

                        <!-- Giá tiền và trạng thái -->
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-sm font-bold text-orange-500">
                                {{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ
                            </p>

                            <div>
                                @if(($sp->so_luong ?? 0) > 0)
                                    <span class="inline-block text-[11px] font-bold text-green-600">
                                        Còn hàng ({{ $sp->so_luong }})
                                    </span>
                                @else
                                    <span class="inline-block text-[11px] font-bold text-red-500">
                                        Hết hàng
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Phân trang nếu dùng Paginate -->
            @if($danhSachCau instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-8">
                    {{ $danhSachCau->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg p-12 text-center border border-gray-200">
                <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500 font-medium">Không tìm thấy sản phẩm cầu cầu lông nào phù hợp.</p>
                <a href="{{ route('cau') }}" class="inline-block mt-4 text-xs bg-orange-500 text-white font-bold px-4 py-2 rounded hover:bg-orange-600 transition">Xem tất cả cầu</a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-amber-50/70 border-t border-amber-100 text-gray-700 text-sm mt-16 pt-10 pb-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 items-start">
                
                <!-- Cột 1: Thông tin công ty -->
                <div class="space-y-3">
                    <p class="font-bold text-slate-900 text-base uppercase tracking-wider">Thông tin công ty</p>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-orange-500 w-4 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Địa chỉ:</strong> Trường Đại học Tài nguyên và Môi trường Hà Nội</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Người nhận:</strong> ManhTominay</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Email:</strong> vdtien26976@gmail.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Cột 2: Danh mục sản phẩm -->
                <div class="space-y-3 md:text-center">
                    <p class="font-bold text-slate-900 text-base uppercase tracking-wider">Danh mục sản phẩm</p>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition block">Vợt cầu lông</a></li>
                        <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition block">Giày cầu lông</a></li>
                        <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition block">Quần áo cầu lông</a></li>
                        <li><a href="{{ route('cau') }}" class="hover:text-orange-500 transition block">Cầu lông</a></li>
                        <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition block">Phụ kiện cầu lông</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Liên hệ -->
                <div class="space-y-3">
                    <p class="font-bold text-slate-900 text-base uppercase tracking-wider">Liên hệ</p>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Hotline:</strong> 0981 852 431</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Hỗ trợ:</strong> vdtien26976@gmail.com</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Giờ làm việc:</strong> 8:00 - 21:00 (T2 - CN)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-location-dot text-orange-500 w-4 flex-shrink-0"></i>
                            <span><strong class="text-slate-900 font-semibold">Cơ sở:</strong> Hà Nội, Việt Nam</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-200/80 pt-6 text-center text-gray-500 text-xs">
                <p>&copy; 2026 BADMINTON PRO SHOP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @include('partials.cart-ajax')
</body>
</html>