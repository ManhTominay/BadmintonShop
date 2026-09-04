<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header / Nav -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-black text-slate-900 tracking-wider">
                BADMINTON <span class="block text-xs font-bold text-orange-500 tracking-normal">PRO SHOP</span>
            </a>

            <!-- Form Tìm Kiếm -->
            <form action="{{ route('tim-kiem') }}" method="GET" class="flex-1 max-w-xl mx-8">
                <div class="relative flex items-center">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm..." class="w-full pl-10 pr-24 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 text-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 text-gray-400"></i>
                    <button type="submit" class="absolute right-1 bg-orange-500 hover:bg-orange-600 text-white font-bold px-4 py-1.5 rounded-md text-sm transition-colors">
                        Tìm kiếm
                    </button>
                </div>
            </form>

            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-orange-500">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Content: Kết quả tìm kiếm -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Banner kết quả -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-8">
            <h1 class="text-xl font-bold uppercase tracking-wide">
                KẾT QUẢ TÌM KIẾM CHO TỪ KHÓA: <span class="text-orange-500">"{{ request('keyword') }}"</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Tìm thấy <span class="font-bold text-gray-800">{{ count($products ?? []) }}</span> sản phẩm phù hợp trên hệ thống.
            </p>
        </div>

        <!-- Danh sách sản phẩm dạng Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $sp)
                <div class="bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between hover:border-orange-500 hover:shadow-lg transition-all duration-300">
                    <div>
                        <!-- Ảnh sản phẩm -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->id) }}" class="block h-48 bg-gray-50 rounded-lg flex items-center justify-center mb-3 p-2 overflow-hidden">
                            @php
                                $imageName = \App\Models\SanPham::resolveImageName($sp->anh_dai_dien ?? null);
                            @endphp
                            <img src="{{ asset('images/' . $imageName) }}" alt="{{ $sp->ten_san_pham }}" class="h-full object-contain hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='{{ asset('images/yonex_doura10.webp') }}';">
                        </a>

                        <!-- Tên sản phẩm -->
                        <a href="{{ route('san-pham.chi-tiet', $sp->id) }}">
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug mb-2 hover:text-orange-500 transition-colors">
                                {{ $sp->ten_san_pham }}
                            </h3>
                        </a>

                        <!-- Giá sản phẩm -->
                        <p class="text-sm font-bold text-orange-500 mb-4">
                            {{ number_format($sp->gia_co_ban ?? $sp->gia, 0, ',', '.') }} VNĐ
                        </p>
                    </div>

                    <!-- Nút THÊM VÀO GIỎ HÀNG (Sửa chuẩn theo Hình 2) -->
                    <form action="{{ route('cart.add', $sp->id) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="bien_the_id" value="{{ optional($sp->bienThes->first())->id ?? 1 }}">
                        <input type="hidden" name="so_luong" value="1">
                        <button type="submit" class="w-full bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white text-xs font-bold py-2.5 rounded-lg transition-colors shadow-sm">
                            Thêm Vào Giỏ Hàng
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl">
                    <p class="text-gray-500">Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>