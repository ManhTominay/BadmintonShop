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
            <button class="text-gray-600 hover:text-orange-500"><i class="fa-solid fa-magnifying-glass text-lg"></i></button>

            <!-- Logo Shop -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <div class="leading-none">
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</h1>
                    <p class="font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</p>
                </div>
            </a>

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
                    <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">TRANG CHỦ</a></li>
                    <li><a href="{{ route('vot-cau-long') }}" class="hover:text-orange-500 transition">VỢT CẦU LÔNG</a></li>
                    <li><a href="{{ route('giay.index') }}" class="hover:text-orange-500 transition">GIÀY CẦU LÔNG</a></li>
                    <li><a href="{{ route('quan-ao') }}" class="hover:text-orange-500 transition">QUẦN ÁO</a></li>
                    <li><a href="{{ route('cau') }}" class="hover:text-orange-500 transition">CẦU</a></li>
                    <li><a href="{{ route('phukien.index') }}" class="text-orange-500 border-b-2 border-orange-500 pb-1">PHỤ KIỆN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Content Phụ Kiện -->
    <div class="max-w-6xl mx-auto px-4 my-6">
        <div class="mb-4">
            <h2 class="text-2xl font-bold uppercase tracking-tight text-slate-900">PHỤ KIỆN CẦU LÔNG</h2>
            <p class="text-gray-500 text-sm">Hiển thị {{ $danhSachPhuKien->count() ?? count($danhSachPhuKien ?? []) }} sản phẩm</p>
        </div>

        <!-- Bộ Lọc Phụ Kiện -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold text-gray-500">Loại phụ kiện:</span>
                <a href="{{ route('phukien.index') }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ !request('type') ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Tất cả</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'bao_vot'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'bao_vot' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Bao vợt</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'cuoc'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'cuoc' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Cước đan</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'cuon_can'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'cuon_can' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Cuốn cán</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'bang_tay'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'bang_tay' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Băng tay</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'bang_dau'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'bang_dau' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Băng trán/đầu</a>
                <a href="{{ route('phukien.index', array_merge(request()->query(), ['type' => 'tat'])) }}" class="px-3 py-1 text-xs border rounded-full hover:border-orange-500 {{ request('type') == 'tat' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">Tất / Vớ</a>
            </div>

            <!-- Tìm kiếm & Sắp xếp -->
            <form action="{{ route('phukien.index') }}" method="GET" class="flex gap-2">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <input type="text" name="keyword" class="border rounded px-3 py-1 text-xs w-48 focus:outline-none focus:border-orange-500" placeholder="Tìm phụ kiện..." value="{{ request('keyword') }}">
                <select name="sort" class="border rounded px-2 py-1 text-xs bg-white focus:outline-none">
                    <option value="">Sắp xếp mặc định</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
                <button type="submit" class="bg-slate-900 text-white px-4 py-1 rounded text-xs font-bold hover:bg-orange-500 transition">Lọc</button>
            </form>
        </div>

        <!-- Danh sách Phụ Kiện -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($danhSachPhuKien as $item)
                <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <!-- Kiểm tra file tồn tại trong public/images, nếu chưa có sẽ hiện khung placeholder tạm thời -->
                        <div class="h-44 bg-gray-100 rounded flex items-center justify-center mb-3 p-2 border border-dashed border-gray-300">
                            @if($item->anh_dai_dien && file_exists(public_path('images/' . $item->anh_dai_dien)))
                                <img src="{{ asset('images/' . $item->anh_dai_dien) }}" 
                                     alt="{{ $item->ten_san_pham }}" 
                                     class="h-full object-contain">
                            @else
                                <div class="text-center text-gray-400">
                                    <i class="fa-regular fa-image text-3xl mb-1"></i>
                                    <p class="text-[10px] uppercase font-semibold">Chưa có ảnh</p>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $item->ten_san_pham }}</h3>
                        <p class="text-xs font-bold text-orange-600 mt-2">{{ number_format($item->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                    </div>
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="bien_the_id" value="{{ $item->bienThes->first()->id ?? 1 }}">
                        <input type="hidden" name="so_luong" value="1">
                        <button type="submit" class="w-full text-center bg-slate-900 text-white text-xs font-bold py-2 rounded hover:bg-orange-500 transition">THÊM VÀO GIỎ</button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    Chưa có sản phẩm phụ kiện nào trong danh mục này.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>