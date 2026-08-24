<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Thêm thư viện Swiper CSS -->
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
            
            <!-- Nút tìm kiếm & Khung nhập tìm kiếm -->
            <div class="relative">
                <button type="button" id="search-toggle-btn" class="text-gray-600 hover:text-orange-500 focus:outline-none p-1">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>

                <!-- Hộp tìm kiếm ẩn/hiện -->
                <div id="search-box" class="hidden absolute left-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-xl p-2 z-50">
                    <form action="{{ url('/') }}" method="GET" class="flex items-center gap-1">
                        <input type="text" name="keyword" placeholder="Nhập tên sản phẩm cần tìm..." 
                               class="w-full text-xs border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-orange-500"
                               autocomplete="off">
                        <button type="submit" class="bg-slate-900 text-white px-3 py-2 rounded text-xs font-bold hover:bg-orange-500 transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Logo Shop -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <div class="leading-none">
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</h1>
                    <p class="font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</p>
                </div>
            </a>

            <!-- Khối Tài Khoản / Giỏ Hàng / Đăng Nhập & Đăng Ký -->
            <div class="flex items-center space-x-4">
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="text-gray-600 hover:text-orange-500" title="Tài khoản">
                    <i class="fa-regular fa-user text-xl"></i>
                </a>

                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php
                        $cartCount = \App\Models\GioHang::where('nguoi_dung_id', 1)->sum('so_luong');
                    @endphp
                    <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                </a>

                <!-- Nút Đăng nhập / Đăng ký bên phải Giỏ hàng -->
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
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 transition py-1 px-1">
                            Đăng nhập
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-3 py-1.5 rounded hover:bg-orange-600 transition shadow-sm">
                            Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <nav class="border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-2 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ url('/') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1">TRANG CHỦ</a></li>
                    <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition">QUẦN ÁO</a></li>
                    <li><a href="{{ url('/cau') }}" class="hover:text-orange-500 transition">CẦU</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- BANNER HERO SLIDER -->
    <section class="relative w-full overflow-hidden bg-gray-100 group">
        <div class="swiper bannerSwiper w-full">
            <div class="swiper-wrapper">
                
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <a href="{{ url('/vot-cau-long?keyword=Yonex') }}" class="block relative w-full">
                        <img src="{{ asset('images/banner-yonex-collage.jpg') }}" 
                             alt="Yonex Badminton Collection" 
                             class="w-full h-[320px] sm:h-[420px] md:h-[480px] object-cover">
                    </a>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <a href="{{ url('/vot-cau-long') }}" class="block relative w-full">
                        <img src="{{ asset('images/banner2.jpg') }}" 
                             alt="Badminton Gear Collection" 
                             class="w-full h-[320px] sm:h-[420px] md:h-[480px] object-cover">
                    </a>
                </div>

            </div>

            <!-- Nút di chuyển TRÁI -->
            <button class="swiper-button-prev-custom absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow-md transition-transform hover:scale-110 focus:outline-none">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>

            <!-- Nút di chuyển PHẢI -->
            <button class="swiper-button-next-custom absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow-md transition-transform hover:scale-110 focus:outline-none">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Shop By Category -->
    <section class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-center font-extrabold text-lg uppercase mb-6">SHOP BY CATEGORY</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            <a href="{{ url('/vot-cau-long') }}" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center hover:bg-orange-500 transition">
                <i class="fa-solid fa-table-tennis-paddle-ball text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">VỢT</span>
            </a>
            <a href="{{ url('/giay-cau-long') }}" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center hover:bg-orange-500 transition">
                <i class="fa-solid fa-shoe-prints text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">GIÀY</span>
            </a>
            <a href="{{ url('/cau') }}" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center hover:bg-orange-500 transition">
                <i class="fa-solid fa-volleyball text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">CẦU</span>
            </a>
            <a href="{{ route('phukien', ['type' => 'bao_vot']) }}" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center hover:bg-orange-500 transition">
                <i class="fa-solid fa-suitcase-rolling text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">TÚI</span>
            </a>
            <a href="{{ route('phukien') }}" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center hover:bg-orange-500 transition">
                <i class="fa-solid fa-socks text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">PHỤ KIỆN</span>
            </a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="max-w-6xl mx-auto px-4 pb-12">
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <h2 class="font-extrabold text-lg uppercase">FEATURED PRODUCTS</h2>
            
            <!-- Filter Tabs Button -->
            <div class="flex flex-wrap gap-2 text-xs font-bold uppercase" id="featured-tabs">
                <button data-type="all" class="tab-btn px-4 py-2 rounded-full bg-slate-900 text-white shadow-sm transition">Tất cả</button>
                <button data-type="new" class="tab-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-500 hover:text-white transition">Sản phẩm mới</button>
                <button data-type="hot" class="tab-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-500 hover:text-white transition">Bán chạy</button>
                <button data-type="sale" class="tab-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-orange-500 hover:text-white transition">Giảm giá hot</button>
            </div>
        </div>

        <!-- Khối hiển thị sản phẩm -->
        <div id="featured-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 min-h-[250px]">

            @foreach($sanPhams as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                @if($sp->la_san_pham_moi)
                    <span class="absolute top-3 left-3 bg-orange-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded z-10">New</span>
                @endif
                <div>
                    <!-- Hiển thị ảnh sản phẩm thực tế -->
                    <div class="h-36 bg-gray-50 rounded flex items-center justify-center mb-3 p-2">
                        @if($sp->anh_dai_dien && file_exists(public_path('images/' . $sp->anh_dai_dien)))
                            <img src="{{ asset('images/' . $sp->anh_dai_dien) }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain">
                        @else
                            <img src="{{ asset('images/yonex_doura10.webp') }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain">
                        @endif
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $sp->ten_san_pham }}</h3>
                    <div class="flex text-yellow-400 text-[10px] my-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-900">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ $sp->bienThes->first()->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded hover:bg-orange-500 transition">Add to Cart</button>
                    <label class="text-[10px] text-gray-500 flex items-center cursor-pointer"><input type="checkbox" class="mr-1"> Compare</label>
                </form>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Thêm Swiper JS & AJAX Filter Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Xử lý bật/tắt hộp tìm kiếm
            const searchBtn = document.getElementById('search-toggle-btn');
            const searchBox = document.getElementById('search-box');

            if (searchBtn && searchBox) {
                searchBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    searchBox.classList.toggle('hidden');
                    if (!searchBox.classList.contains('hidden')) {
                        searchBox.querySelector('input').focus();
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!searchBox.contains(e.target) && !searchBtn.contains(e.target)) {
                        searchBox.classList.add('hidden');
                    }
                });
            }

            // Khởi tạo Swiper Banner
            const swiper = new Swiper('.bannerSwiper', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
            });

            // Xử lý chuyển tab AJAX
            const tabs = document.querySelectorAll('.tab-btn');
            const grid = document.getElementById('featured-products-grid');
            const csrfToken = '{{ csrf_token() }}';

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Active State cho các nút Tab
                    tabs.forEach(t => {
                        t.classList.remove('bg-slate-900', 'text-white');
                        t.classList.add('bg-gray-100', 'text-gray-600');
                    });
                    this.classList.remove('bg-gray-100', 'text-gray-600');
                    this.classList.add('bg-slate-900', 'text-white');

                    const type = this.dataset.type;

                    // Hiển thị trạng thái đang tải
                    grid.innerHTML = `<div class="col-span-full text-center py-12 text-gray-400 font-medium"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Đang tải sản phẩm...</div>`;

                    // Gọi API lấy dữ liệu sản phẩm tương ứng
                    fetch(`{{ route('featured.products') }}?type=${type}`)
                        .then(res => res.json())
                        .then(products => {
                            if (products.length === 0) {
                                grid.innerHTML = `<div class="col-span-full text-center py-12 text-gray-500 text-sm">Không tìm thấy sản phẩm nào.</div>`;
                                return;
                            }

                            grid.innerHTML = products.map(sp => `
                                <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                                    ${sp.la_san_pham_moi ? '<span class="absolute top-3 left-3 bg-orange-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded z-10">New</span>' : ''}
                                    <div>
                                        <div class="h-36 bg-gray-50 rounded flex items-center justify-center mb-3 p-2">
                                            <img src="/images/${sp.anh_dai_dien ? sp.anh_dai_dien.replace(/^\//, '') : 'yonex_doura10.webp'}" alt="${sp.ten_san_pham}" class="h-full object-contain">
                                        </div>
                                        <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">${sp.ten_san_pham}</h3>
                                        <div class="flex text-yellow-400 text-[10px] my-1">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-900">${new Intl.NumberFormat('vi-VN').format(sp.gia_co_ban)} VNĐ</p>
                                    </div>
                                    
                                    <form action="/gio-hang/them/${sp.id}" method="POST" class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="bien_the_id" value="${sp.bien_thes && sp.bien_thes.length > 0 ? sp.bien_thes[0].id : 1}">
                                        <input type="hidden" name="so_luong" value="1">
                                        <button type="submit" class="bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded hover:bg-orange-500 transition">Add to Cart</button>
                                        <label class="text-[10px] text-gray-500 flex items-center cursor-pointer"><input type="checkbox" class="mr-1"> Compare</label>
                                    </form>
                                </div>
                            `).join('');
                        })
                        .catch(() => {
                            grid.innerHTML = `<div class="col-span-full text-center py-12 text-red-500 text-sm">Có lỗi xảy ra khi tải dữ liệu!</div>`;
                        });
                });
            });
        });
    </script>
</body>
</html>