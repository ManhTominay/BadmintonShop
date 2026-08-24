<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm: "{{ $keyword ?? '' }}" - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Top Bar -->
    <div class="bg-slate-900 text-white text-xs py-1 text-center font-medium">
        Badminton Essential Equipment
    </div>

    <!-- Header độc lập của trang tìm kiếm -->
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

            <!-- Thanh tìm kiếm kiểu dáng mới (Border cam, nút Tìm kiếm nằm trong khung) -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ url('/tim-kiem') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    <!-- Ô nhập từ khóa (Có icon kính lúp bên trái) -->
                    <div class="flex items-center flex-1 px-3 py-1.5">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2 text-sm"></i>
                        <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Tìm kiếm sản phẩm..." 
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
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="text-gray-600 hover:text-orange-500" title="Tài khoản">
                    <i class="fa-regular fa-user text-xl"></i>
                </a>
                <a href="#" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </div>
        </div>

        <nav class="border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-2 text-xs font-bold uppercase tracking-wider">
                    <li><a href="{{ url('/') }}" class="hover:text-orange-500 transition">TRANG CHỦ</a></li>
                    <li><a href="{{ url('/vot-cau-long') }}" class="hover:text-orange-500 transition">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ url('/giay-cau-long') }}" class="hover:text-orange-500 transition">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ url('/quan-ao') }}" class="hover:text-orange-500 transition">QUẦN ÁO</a></li>
                    <li><a href="{{ url('/cau') }}" class="hover:text-orange-500 transition">CẦU</a></li>
                    <li><a href="{{ route('phukien') }}" class="hover:text-orange-500 transition">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content: Kết quả tìm kiếm riêng biệt -->
    <main class="max-w-6xl mx-auto px-4 py-8 min-h-[500px]">
        
        <!-- Tiêu đề kết quả -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <h1 class="text-base font-extrabold uppercase text-slate-900 mb-2">
                Kết quả tìm kiếm cho từ khóa: <span class="text-orange-500">"{{ $keyword ?? 'Tất cả' }}"</span>
            </h1>
            <p class="text-xs text-gray-500 mb-4">Tìm thấy <strong class="text-slate-800">{{ isset($sanPhams) ? count($sanPhams) : 0 }}</strong> sản phẩm phù hợp trên hệ thống.</p>
            
            <!-- Gợi ý nhanh -->
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="font-bold text-gray-600 mr-2">Từ khóa phổ biến:</span>
                <a href="{{ url('/tim-kiem?keyword=lining') }}" class="px-3 py-1 bg-gray-100 hover:bg-orange-500 hover:text-white rounded-full transition font-medium">Lining</a>
                <a href="{{ url('/tim-kiem?keyword=yonex') }}" class="px-3 py-1 bg-gray-100 hover:bg-orange-500 hover:text-white rounded-full transition font-medium">Yonex</a>
                <a href="{{ url('/tim-kiem?keyword=victor') }}" class="px-3 py-1 bg-gray-100 hover:bg-orange-500 hover:text-white rounded-full transition font-medium">Victor</a>
                <a href="{{ url('/tim-kiem?keyword=giay') }}" class="px-3 py-1 bg-gray-100 hover:bg-orange-500 hover:text-white rounded-full transition font-medium">Giày</a>
            </div>
        </div>

        <!-- Lưới hiển thị sản phẩm -->
        @if(isset($sanPhams) && count($sanPhams) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($sanPhams as $sp)
                <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                    <div>
                        <div class="h-36 bg-gray-50 rounded flex items-center justify-center mb-3 p-2">
                            @if(!empty($sp->anh_dai_dien) && file_exists(public_path('images/' . $sp->anh_dai_dien)))
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
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                        @csrf
                        <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                        <input type="hidden" name="so_luong" value="1">
                        <button type="submit" class="bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded hover:bg-orange-500 transition">Add to Cart</button>
                        <label class="text-[10px] text-gray-500 flex items-center cursor-pointer"><input type="checkbox" class="mr-1"> Compare</label>
                    </form>
                </div>
                @endforeach
            </div>
        @else
            <!-- Trạng thái trống -->
            <div class="bg-white rounded-lg p-12 text-center border border-gray-100">
                <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                <h2 class="text-sm font-bold text-gray-700 mb-1">Không tìm thấy sản phẩm nào phù hợp!</h2>
                <p class="text-xs text-gray-400 mb-4">Hãy thử kiểm tra lại chính tả hoặc tìm kiếm với từ khóa khác.</p>
                <a href="{{ url('/') }}" class="inline-block bg-slate-900 text-white text-xs font-bold px-5 py-2.5 rounded hover:bg-orange-500 transition">
                    Quay về trang chủ
                </a>
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white text-xs py-6 text-center mt-12">
        <p>&copy; 2026 BADMINTON PRO SHOP. All rights reserved.</p>
    </footer>

</body>
</html>