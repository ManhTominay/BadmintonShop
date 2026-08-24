<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẦN ÁO CẦU LÔNG - BADMINTON PRO SHOP</title>
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
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <div class="leading-none">
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</h1>
                    <p class="font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</p>
                </div>
            </a>

            <!-- Thanh tìm kiếm kiểu dáng mới (Border cam, nút Tìm kiếm nằm trong khung) ở Header -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ url('/quan-ao') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    <!-- Ô nhập từ khóa (Có icon kính lúp bên trái) -->
                    <div class="flex items-center flex-1 px-3 py-1.5">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2 text-sm"></i>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm sản phẩm..." 
                               class="w-full text-xs text-gray-700 bg-transparent focus:outline-none placeholder-gray-400"
                               autocomplete="off">
                    </div>
                    <!-- Nút Tìm kiếm màu cam bên phải -->
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-4 py-2 text-xs transition duration-150">
                        Tìm kiếm
                    </button>
                </form>
            </div>

            <!-- Giỏ hàng & Tài khoản -->
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-orange-500"><i class="fa-regular fa-user text-xl"></i></a>
                <a href="#" class="relative text-gray-600 hover:text-orange-500">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>

        <nav class="border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-2 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ url('/') }}" class="hover:text-orange-500 transition">TRANG CHỦ</a></li>
                    <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ url('/quan-ao') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1">QUẦN ÁO</a></li>
                    <li><a href="{{ route('cau') }}" class="hover:text-orange-500 transition">CẦU</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 uppercase">QUẦN ÁO CẦU LÔNG</h1>
                <p class="text-xs text-gray-500 mt-1">Hiển thị {{ isset($danhSachQuanAo) ? $danhSachQuanAo->count() : 0 }} sản phẩm</p>
            </div>

            <!-- Bộ lọc Sắp xếp -->
            <form action="{{ url('/quan-ao') }}" method="GET" class="flex items-center gap-2">
                @if(request('keyword'))
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @endif
                <label class="text-xs font-semibold text-gray-600 whitespace-nowrap">Sắp xếp:</label>
                <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-2 text-xs bg-white focus:outline-none focus:border-orange-500 cursor-pointer">
                    <option value="">Sắp xếp mặc định</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                </select>
            </form>
        </div>

        <!-- Grid Danh sách Quần Áo -->
        @if(isset($danhSachQuanAo) && $danhSachQuanAo->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($danhSachQuanAo as $sp)
                <div class="bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between hover:border-orange-500 hover:shadow-lg transition-all duration-300">
                    <div>
                        <!-- Khung ảnh sản phẩm (Click vào ảnh dẫn đến chi tiết) -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->slug ?? $sp->id) }}" class="block h-44 bg-gray-50 rounded-lg flex items-center justify-center mb-3 p-2 overflow-hidden">
                            @if($sp->anh_dai_dien && file_exists(public_path('images/' . $sp->anh_dai_dien)))
                                <img src="{{ asset('images/' . $sp->anh_dai_dien) }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain hover:scale-105 transition-transform duration-300">
                            @else
                                <i class="fa-solid fa-shirt text-5xl text-gray-300"></i>
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
                    </div>

                    <!-- Giá tiền -->
                    <div class="mt-2">
                        <p class="text-sm font-bold text-orange-500">
                            {{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg p-12 text-center border border-gray-200">
                <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500 font-medium">Không tìm thấy sản phẩm quần áo nào phù hợp.</p>
                <a href="{{ url('/quan-ao') }}" class="inline-block mt-4 text-xs bg-orange-500 text-white font-bold px-4 py-2 rounded hover:bg-orange-600 transition">Xem tất cả quần áo</a>
            </div>
        @endif
    </main>

</body>
</html>