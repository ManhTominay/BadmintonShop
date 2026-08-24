<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sanPham->ten_san_pham ?? 'Chi tiết sản phẩm' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/vot-cau-long') }}" class="text-xs font-bold text-orange-500 flex items-center gap-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách vợt
            </a>
            <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON PRO</a>
            <div></div>
        </div>
    </header>

    <!-- Nội dung chi tiết sản phẩm -->
    <div class="max-w-6xl mx-auto px-4 py-10">
        
        <!-- Hiển thị thông báo thành công khi thêm vào giỏ hàng -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-sm font-bold flex items-center shadow-sm">
                <i class="fa-solid fa-check-circle mr-2 text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Cột hình ảnh sản phẩm -->
            <div class="bg-gray-50 rounded-xl flex items-center justify-center p-6 h-96">
                @php
                    $imageName = !empty($sanPham->anh_dai_dien) ? $sanPham->anh_dai_dien : 'yonex_doura10.webp';
                @endphp
                <img src="{{ asset('images/' . $imageName) }}" 
                     onerror="this.onerror=null; this.src='{{ asset('images/yonex_doura10.webp') }}';"
                     class="max-h-full max-w-full object-contain"
                     alt="{{ $sanPham->ten_san_pham }}">
            </div>

            <!-- Cột thông tin chi tiết -->
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-3">
                        {{ $sanPham->ten_san_pham }}
                    </h1>
                    
                    <div class="text-2xl font-bold text-orange-500 mb-6">
                        {{ number_format($sanPham->gia_co_ban, 0, ',', '.') }} VNĐ
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <h3 class="text-sm font-bold text-gray-700 uppercase mb-2">Mô tả sản phẩm:</h3>
                        <div class="text-sm text-gray-600 leading-relaxed space-y-2">
                            {!! $sanPham->mo_ta ?? 'Đang cập nhật thông tin chi tiết cho sản phẩm này...' !!}
                        </div>
                    </div>
                </div>

                <!-- Form thêm vào giỏ hàng có kèm token và bien_the_id -->
                <form action="{{ route('cart.add', $sanPham->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ $sanPham->id }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md cursor-pointer">
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </form>
            </div>

        </div>

        <!-- Sản phẩm liên quan -->
        @if(isset($sanPhamLienQuan) && $sanPhamLienQuan->count() > 0)
        <div class="mt-16">
            <h2 class="text-xl font-black text-slate-900 mb-6">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($sanPhamLienQuan as $item)
                <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <a href="{{ route('san-pham.chi-tiet', $item->slug ?? $item->id) }}">
                        <div class="h-36 bg-gray-50 rounded-lg flex items-center justify-center mb-3 p-2">
                            <img src="{{ asset('images/' . ($item->anh_dai_dien ?? 'yonex_doura10.webp')) }}" class="h-full w-full object-contain">
                        </div>
                        <h3 class="text-xs font-bold text-gray-800 line-clamp-2 h-8">{{ $item->ten_san_pham }}</h3>
                    </a>
                    <p class="text-xs font-bold text-orange-500 mt-2">{{ number_format($item->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</body>
</html>