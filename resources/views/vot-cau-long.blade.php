<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DANH SÁCH VỢT CẦU LÔNG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Header tiêu đề & số lượng -->
        <div class="flex items-center gap-3 mb-6">
            <h1 class="text-2xl font-black text-slate-900">Vợt cầu lông</h1>
            <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full">
                {{ $danhSachVot->count() }} sản phẩm
            </span>
        </div>

        <!-- Form Tìm kiếm & Sắp xếp -->
        <form action="{{ route('vot-cau-long') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            
            <!-- Ô tìm kiếm -->
            <div class="relative w-full md:w-2/3 flex items-center">
                <i class="fa-solid fa-magnifying-glass absolute left-4 text-gray-400"></i>
                <input type="text" 
                       name="keyword" 
                       value="{{ request('keyword') }}"
                       placeholder="Nhập tên hãng hoặc mẫu vợt (VD: Yonex, Lining, Victor...)" 
                       class="w-full pl-11 pr-28 py-2.5 bg-gray-100 rounded-lg text-sm border-none focus:ring-2 focus:ring-orange-500 outline-none">
                <button type="submit" class="absolute right-1.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs px-5 py-2 rounded-md transition-colors">
                    Tìm kiếm
                </button>
            </div>

            <!-- Bộ lọc Sắp xếp -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                <label class="text-xs font-semibold text-gray-600 whitespace-nowrap">Sắp xếp:</label>
                <select name="sort" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-700 text-xs rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-orange-500 cursor-pointer">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                </select>
            </div>

        </form>

        <!-- Gợi ý từ khóa thương hiệu phổ biến -->
        <div class="flex items-center gap-2 mb-8 flex-wrap">
            <span class="text-xs text-gray-500 font-medium">Thương hiệu hot:</span>
            <a href="{{ route('vot-cau-long', ['keyword' => 'Yonex']) }}" class="text-xs bg-white hover:bg-orange-50 text-gray-700 hover:text-orange-600 border border-gray-200 px-3 py-1 rounded-full transition-colors {{ request('keyword') == 'Yonex' ? 'border-orange-500 text-orange-600 font-bold' : '' }}">Yonex</a>
            <a href="{{ route('vot-cau-long', ['keyword' => 'Lining']) }}" class="text-xs bg-white hover:bg-orange-50 text-gray-700 hover:text-orange-600 border border-gray-200 px-3 py-1 rounded-full transition-colors {{ request('keyword') == 'Lining' ? 'border-orange-500 text-orange-600 font-bold' : '' }}">Lining</a>
            <a href="{{ route('vot-cau-long', ['keyword' => 'Victor']) }}" class="text-xs bg-white hover:bg-orange-50 text-gray-700 hover:text-orange-600 border border-gray-200 px-3 py-1 rounded-full transition-colors {{ request('keyword') == 'Victor' ? 'border-orange-500 text-orange-600 font-bold' : '' }}">Victor</a>
            @if(request('keyword'))
            <a href="{{ route('vot-cau-long') }}" class="text-xs text-red-500 hover:underline ml-2">Xóa bộ lọc</a>
            @endif
        </div>
        
        <!-- Danh sách Vợt -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($danhSachVot as $sp)
            <div class="group bg-white rounded-xl p-4 border border-gray-100 flex flex-col justify-between hover:shadow-lg hover:border-orange-500 transition-all duration-300">
                
                <div>
                    <!-- Khung ảnh sản phẩm -->
                    <div class="h-44 bg-gray-50 rounded-lg flex items-center justify-center mb-3 p-2 overflow-hidden">
                        <img src="{{ asset('images/' . ($sp->anh_dai_dien ?? 'yonex_doura10.webp')) }}" 
                             class="h-full object-contain group-hover:scale-105 transition-transform duration-300"
                             alt="{{ $sp->ten_san_pham }}">
                    </div>

                    <!-- Nút Xem chi tiết khi hover -->
                    <div class="mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="#" class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center font-bold text-xs uppercase py-2 rounded transition-colors shadow">
                            XEM CHI TIẾT
                        </a>
                    </div>
                </div>

                <!-- Thông tin tên & giá -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 h-10 leading-snug">
                        {{ $sp->ten_san_pham }}
                    </h3>
                    <p class="text-sm font-bold text-orange-500 mt-2">
                        {{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ
                    </p>
                </div>

            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                Không tìm thấy vợt nào phù hợp với từ khóa "<span class="font-bold text-gray-700">{{ request('keyword') }}</span>".
            </div>
            @endforelse
        </div>

    </div>
</body>
</html>