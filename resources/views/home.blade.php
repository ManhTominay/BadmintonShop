<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Top Bar -->
    <div class="bg-slate-900 text-white text-xs py-1 text-center font-medium">
        Badminton Essential Equipment
    </div>

    <!-- Header Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            
            <!-- 1. Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="block">
                    <span class="text-2xl font-extrabold tracking-wider text-slate-900">BADMINTON</span>
                    <span class="block text-xs font-bold tracking-widest text-orange-500 uppercase">PRO SHOP</span>
                </a>
            </div>

            <!-- 2. Khung tìm kiếm ở giữa -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ route('product.search') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    <div class="relative flex items-center flex-1 px-4 py-2">
                        <span class="absolute left-4 text-gray-400 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm sản phẩm trên toàn hệ thống..." 
                               class="w-full text-sm text-gray-700 bg-transparent pl-7 pr-2 focus:outline-none placeholder-gray-400"
                               autocomplete="off">
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2.5 text-sm transition duration-150">
                        Tìm kiếm
                    </button>
                </form>
            </div>

            <!-- 3. Tài khoản & Giỏ hàng -->
            <div class="flex items-center space-x-4">
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="text-gray-600 hover:text-orange-500" title="Tài khoản">
                    <i class="fa-regular fa-user text-xl"></i>
                </a>

                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php
                        $cartCount = 0;
                        if (Auth::check()) {
                            $cartCount = \App\Models\GioHang::where('nguoi_dung_id', Auth::id())->sum('so_luong');
                        }
                    @endphp
                    <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                </a>

                <div class="flex items-center space-x-2 text-xs font-semibold pl-2 border-l border-gray-200">
                    @auth
                        <span class="text-slate-700">
                            Xin chào, <strong class="text-orange-500 font-bold">{{ Auth::user()->ho_ten ?? Auth::user()->full_name ?? Auth::user()->name ?? Auth::user()->username }}</strong>
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-orange-500 transition ml-1">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 transition py-1 px-1">Đăng nhập</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-3 py-1.5 rounded hover:bg-orange-600 transition shadow-sm">Đăng ký</a>
                    @endauth
                </div>
            </div>

        </div>

        <!-- Menu Ngang ở Header -->
        <nav class="border-t border-gray-100 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-3 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ url('/') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1 transition">Trang chủ</a></li>
                    <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition">Vợt</a></li>
                    <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition">Giày</a></li>
                    <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition">Quần áo</a></li>
                    <li><a href="{{ url('/cau') }}" class="hover:text-orange-500 transition">Cầu</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">Phụ kiện</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- BANNER HERO SLIDER -->
    <section class="relative w-full overflow-hidden bg-gray-100 group">
        <div class="swiper bannerSwiper w-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('images/banner-yonex-collage.jpg') }}" class="w-full h-[320px] sm:h-[420px] md:h-[480px] object-cover">
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('images/banner2.jpg') }}" class="w-full h-[320px] sm:h-[420px] md:h-[480px] object-cover">
                </div>
            </div>
            <button class="swiper-button-prev-custom absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow-md transition-transform hover:scale-110">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button class="swiper-button-next-custom absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow-md transition-transform hover:scale-110">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- 3 KHỐI DỊCH VỤ DƯỚI BANNER -->
    <section class="max-w-6xl mx-auto px-4 my-8">
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 py-6">
            
            <div class="flex flex-col items-center text-center px-4 py-3">
                <div class="w-12 h-12 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-orange-500 mb-3 shadow-sm">
                    <i class="fa-solid fa-truck-fast text-lg"></i>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 uppercase tracking-wide">SHIP HÀNG TOÀN QUỐC</h4>
                <p class="text-xs text-gray-500 mt-1">HỖ TRỢ SHIP TOÀN QUỐC</p>
            </div>

            <div class="flex flex-col items-center text-center px-4 py-3">
                <div class="w-12 h-12 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-orange-500 mb-3 shadow-sm">
                    <i class="fa-solid fa-award text-lg"></i>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 uppercase tracking-wide">CHẤT LƯỢNG ĐẢM BẢO</h4>
                <p class="text-xs text-gray-500 mt-1">CAM KẾT CHÍNH HÃNG, UY TÍN</p>
            </div>

            <div class="flex flex-col items-center text-center px-4 py-3">
                <div class="w-12 h-12 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-orange-500 mb-3 shadow-sm">
                    <i class="fa-solid fa-headset text-lg"></i>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 uppercase tracking-wide">HỖ TRỢ 24/7</h4>
                <p class="text-xs text-gray-500 mt-1">CHĂM SÓC KHÁCH HÀNG 24/7</p>
            </div>

        </div>
    </section>

    <!-- 0. DANH MỤC: SẢN PHẨM BÁN CHẠY -->
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between relative h-10">
            <div class="absolute left-0 top-1/2 w-full h-[1px] bg-gray-200 z-0"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10 bg-gray-50 px-4">
                <h2 class="font-extrabold text-xl uppercase tracking-wider text-slate-900 text-center">SẢN PHẨM BÁN CHẠY</h2>
            </div>
            <a href="{{ url('/san-pham-ban-chay') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-50 pl-4 text-sm font-bold text-orange-600 hover:text-orange-700 z-10 flex items-center gap-1.5 transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @php
                if (isset($banChay) && count($banChay) > 0) {
                    $sanPhamBanChay = $banChay;
                } else {
                    $allSp = \App\Models\SanPham::all();

                    $pVot     = $allSp->filter(function($p) { return stripos($p->ten_san_pham, 'vợt') !== false; })->take(2);
                    $pGiay    = $allSp->filter(function($p) { return stripos($p->ten_san_pham, 'giày') !== false; })->take(2);
                    $pAo      = $allSp->filter(function($p) { return stripos($p->ten_san_pham, 'áo') !== false; })->take(1);
                    $pQuan    = $allSp->filter(function($p) { return stripos($p->ten_san_pham, 'quần') !== false; })->take(1);
                    $pCau     = $allSp->filter(function($p) { return stripos($p->ten_san_pham, 'cầu') !== false; })->take(1);
                    $pPhuKien = $allSp->filter(function($p) { 
                        return stripos($p->ten_san_pham, 'phụ kiện') !== false || 
                               stripos($p->ten_san_pham, 'quấn') !== false || 
                               stripos($p->ten_san_pham, 'túi') !== false || 
                               stripos($p->ten_san_pham, 'balo') !== false; 
                    })->take(1);

                    $sanPhamBanChay = collect()->concat($pVot)->concat($pGiay)->concat($pAo)->concat($pQuan)->concat($pCau)->concat($pPhuKien);

                    if ($sanPhamBanChay->count() < 8) {
                        $sanPhamBanChay = $allSp->take(8);
                    } else {
                        $sanPhamBanChay = $sanPhamBanChay->take(8);
                    }
                }
            @endphp

            @foreach($sanPhamBanChay as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                <div>
                    <div class="h-44 bg-gray-50 rounded flex items-center justify-center mb-3 p-2 relative overflow-hidden">
                        <img src="{{ $sp->anh_dai_dien ? asset('images/' . $sp->anh_dai_dien) : asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain pointer-events-none select-none">
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2 rounded transition">Thêm Vào Giỏ Hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 1. DANH MỤC: VỢT CẦU LÔNG -->
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between relative h-10">
            <div class="absolute left-0 top-1/2 w-full h-[1px] bg-gray-200 z-0"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10 bg-gray-50 px-4">
                <h2 class="font-extrabold text-xl uppercase tracking-wider text-slate-900 text-center">VỢT CẦU LÔNG</h2>
            </div>
            <a href="{{ url('/vot-cau-long') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-50 pl-4 text-sm font-bold text-orange-600 hover:text-orange-700 z-10 flex items-center gap-1.5 transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($votCaulong as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                <div>
                    <div class="h-44 bg-gray-50 rounded flex items-center justify-center mb-3 p-2 relative overflow-hidden">
                        <img src="{{ $sp->anh_dai_dien ? asset('images/' . $sp->anh_dai_dien) : asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain pointer-events-none select-none">
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2 rounded transition">Thêm Vào Giỏ Hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 2. DANH MỤC: GIÀY CẦU LÔNG -->
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between relative h-10">
            <div class="absolute left-0 top-1/2 w-full h-[1px] bg-gray-200 z-0"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10 bg-gray-50 px-4">
                <h2 class="font-extrabold text-xl uppercase tracking-wider text-slate-900 text-center">GIÀY CẦU LÔNG</h2>
            </div>
            <a href="{{ url('/giay-cau-long') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-50 pl-4 text-sm font-bold text-orange-600 hover:text-orange-700 z-10 flex items-center gap-1.5 transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($giayCaulong as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                <div>
                    <div class="h-44 bg-gray-50 rounded flex items-center justify-center mb-3 p-2 relative overflow-hidden">
                        <img src="{{ $sp->anh_dai_dien ? asset('images/' . $sp->anh_dai_dien) : asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain pointer-events-none select-none">
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2 rounded transition">Thêm Vào Giỏ Hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 3. DANH MỤC: QUẦN ÁO CẦU LÔNG -->
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between relative h-10">
            <div class="absolute left-0 top-1/2 w-full h-[1px] bg-gray-200 z-0"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10 bg-gray-50 px-4">
                <h2 class="font-extrabold text-xl uppercase tracking-wider text-slate-900 text-center">QUẦN ÁO CẦU LÔNG</h2>
            </div>
            <a href="{{ url('/quan-ao') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-50 pl-4 text-sm font-bold text-orange-600 hover:text-orange-700 z-10 flex items-center gap-1.5 transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $listQuanAo = isset($quanAo) ? $quanAo : (isset($quan_ao) ? $quan_ao : \App\Models\SanPham::where('ten_san_pham', 'like', '%áo%')->orWhere('ten_san_pham', 'like', '%quần%')->take(4)->get());
            @endphp

            @foreach($listQuanAo as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                <div>
                    <div class="h-44 bg-gray-50 rounded flex items-center justify-center mb-3 p-2 relative overflow-hidden">
                        <img src="{{ $sp->anh_dai_dien ? asset('images/' . $sp->anh_dai_dien) : asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain pointer-events-none select-none">
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2 rounded transition">Thêm Vào Giỏ Hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 4. DANH MỤC: PHỤ KIỆN -->
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between relative h-10">
            <div class="absolute left-0 top-1/2 w-full h-[1px] bg-gray-200 z-0"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10 bg-gray-50 px-4">
                <h2 class="font-extrabold text-xl uppercase tracking-wider text-slate-900 text-center">PHỤ KIỆN CẦU LÔNG</h2>
            </div>
            <a href="{{ route('phukien') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-50 pl-4 text-sm font-bold text-orange-600 hover:text-orange-700 z-10 flex items-center gap-1.5 transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($phuKien as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                <div>
                    <div class="h-44 bg-gray-50 rounded flex items-center justify-center mb-3 p-2 relative overflow-hidden">
                        <img src="{{ $sp->anh_dai_dien ? asset('images/' . $sp->anh_dai_dien) : asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain pointer-events-none select-none">
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2 rounded transition">Thêm Vào Giỏ Hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.bannerSwiper', {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next-custom', prevEl: '.swiper-button-prev-custom' },
            });
        });
    </script>

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
                <div class="space-y-3 text-center">
                    <p class="font-bold text-slate-900 text-base uppercase tracking-wider">Danh mục sản phẩm</p>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition block">Vợt cầu lông</a></li>
                        <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition block">Giày cầu lông</a></li>
                        <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition block">Quần áo cầu lông</a></li>
                        <li><a href="{{ url('/cau') }}" class="hover:text-orange-500 transition block">Cầu lông</a></li>
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
</body>
</html>