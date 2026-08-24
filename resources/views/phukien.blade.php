<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHỤ KIỆN CẦU LÔNG - BADMINTON PRO SHOP</title>
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
                <form action="{{ route('phukien') }}" method="GET" class="flex items-center w-full border-2 border-orange-500 rounded-lg overflow-hidden bg-white shadow-sm">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
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

            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-orange-500"><i class="fa-regular fa-user text-xl"></i></a>
                <a href="#" class="relative text-gray-600 hover:text-orange-500">
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
                    <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">TRANG CHỦ</a></li>
                    <li><a href="{{ route('vot-cau-long') }}" class="hover:text-orange-500 transition">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ route('giay.index') }}" class="hover:text-orange-500 transition">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ route('quan-ao') }}" class="hover:text-orange-500 transition">QUẦN ÁO</a></li>
                    <li><a href="{{ route('cau') }}" class="hover:text-orange-500 transition">CẦU</a></li>
                    <li><a href="{{ route('phukien') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Content Phụ Kiện -->
    <div class="max-w-6xl mx-auto px-4 my-6">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900">PHỤ KIỆN CẦU LÔNG</h2>
                <p class="text-gray-500 text-xs mt-1">
                    Hiển thị {{ $danhSachPhuKien instanceof \Illuminate\Pagination\LengthAwarePaginator ? $danhSachPhuKien->total() : count($danhSachPhuKien) }} sản phẩm
                </p>
            </div>

            <!-- Form Sắp xếp (Thanh tìm kiếm phụ đã được chuyển lên Header chuẩn) -->
            <form action="{{ route('phukien') }}" method="GET" class="flex items-center gap-2">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request('keyword'))
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @endif
                <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-1.5 text-xs bg-white focus:outline-none focus:border-orange-500 text-gray-700 cursor-pointer">
                    <option value="">Sắp xếp mặc định</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
            </form>
        </div>

        <!-- Bộ Lọc Phụ Kiện -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <span class="text-xs font-bold text-gray-500 mr-1">Loại phụ kiện:</span>
            
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'tat_ca'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ !request('type') || request('type') == 'tat_ca' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Tất cả</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'bao_vot'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'bao_vot' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Bao vợt</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'cuoc'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'cuoc' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Cước đan</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'cuon_can'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'cuon_can' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Cuốn cán</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'bang_tay'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'bang_tay' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Băng tay</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'bang_dau'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'bang_dau' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Băng trán/đầu</a>
               
            <a href="{{ route('phukien', array_merge(request()->except('type'), ['type' => 'tat'])) }}" 
               class="px-3 py-1 text-xs border rounded-full transition {{ request('type') == 'tat' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 hover:border-orange-500' }}">Tất / Vớ</a>
        </div>

        <!-- Danh sách Phụ Kiện -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
            @forelse($danhSachPhuKien as $item)
                <div class="bg-white rounded-xl p-3 border border-gray-100 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                    <div>
                        <!-- Khung Ảnh (Bấm vào ảnh chuyển đến trang chi tiết) -->
                        <a href="{{ route('san-pham.chi-tiet', $item->slug ?? $item->id) }}" class="block h-48 bg-gray-50 rounded-lg flex items-center justify-center p-2 mb-3 overflow-hidden relative">
                            @if($item->anh_dai_dien)
                                <img src="{{ asset('images/' . ltrim($item->anh_dai_dien, '/')) }}" 
                                     alt="{{ $item->ten_san_pham }}" 
                                     class="max-h-full max-w-full object-contain hover:scale-105 transition-transform duration-300"
                                     onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                <span class="hidden text-xs text-gray-400 font-medium">Không tìm thấy ảnh</span>
                            @else
                                <span class="text-xs text-gray-400 font-medium">Chưa có ảnh</span>
                            @endif
                        </a>

                        <!-- Nút XEM CHI TIẾT -->
                        <a href="{{ route('san-pham.chi-tiet', $item->slug ?? $item->id) }}" class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center font-bold text-xs py-2 rounded-lg uppercase tracking-wide mb-3 transition">
                            XEM CHI TIẾT
                        </a>

                        <!-- Tên sản phẩm (Bấm vào tên chuyển đến trang chi tiết) -->
                        <a href="{{ route('san-pham.chi-tiet', $item->slug ?? $item->id) }}">
                            <h3 class="text-xs font-bold text-gray-900 line-clamp-2 min-h-[32px] hover:text-orange-500 transition-colors">
                                {{ $item->ten_san_pham }}
                            </h3>
                        </a>
                    </div>

                    <!-- Giá sản phẩm -->
                    <div class="mt-2">
                        <p class="text-xs font-bold text-orange-600">
                            {{ number_format($item->gia_co_ban, 0, ',', '.') }} VNĐ
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 text-sm">
                    Chưa có sản phẩm phụ kiện nào trong danh mục này.
                </div>
            @endforelse
        </div>

        <!-- Phân trang -->
        @if($danhSachPhuKien instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">
                {{ $danhSachPhuKien->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</body>
</html>