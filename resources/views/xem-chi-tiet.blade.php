<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sanPham->ten_san_pham ?? 'Chi tiết sản phẩm' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/vot-cau-long') }}" class="text-xs font-bold text-orange-500 flex items-center gap-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
            </a>
            <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON PRO</a>
            <div class="flex items-center">
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-orange-500" title="Giỏ hàng">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php
                        $headerCartCount = Auth::check() ? \App\Models\GioHang::validCartCount(Auth::id()) : 0;
                    @endphp
                    <span data-cart-count class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                        {{ $headerCartCount }}
                    </span>
                </a>
            </div>
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
                    $imageName = \App\Models\SanPham::resolveImageName($sanPham->anh_dai_dien ?? null);
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
                    
                    <div class="text-2xl font-bold text-orange-500 mb-6" id="product-price">
                        {{ number_format($sanPham->gia_co_ban, 0, ',', '.') }} VNĐ
                    </div>

                    <!-- Lựa chọn biến thể sản phẩm (Màu sắc / Phiên bản) -->
                    @if(isset($sanPham->bienThes) && $sanPham->bienThes->count() > 0)
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Chọn phiên bản / Biến thể:</label>
                        <div class="flex flex-wrap gap-2" id="variant-container">
                            @foreach($sanPham->bienThes as $index => $bienThe)
                                <button type="button" 
                                        data-id="{{ $bienThe->id }}" 
                                        data-price="{{ $bienThe->gia ?? $sanPham->gia_co_ban }}"
                                        class="variant-btn px-4 py-2 text-xs font-bold rounded-lg border {{ $index === 0 ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-400' }} transition">
                                    {{ $bienThe->ten_bien_the ?? $bienThe->sku ?? 'Phiên bản ' . ($index + 1) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @php
                        $categoryId = (int) ($sanPham->danh_muc_id ?? 0);
                        $showSizeSelector = in_array($categoryId, [2, 4, 6], true);
                        $sizeList = $categoryId === 2
                            ? ['36', '37', '38', '39', '40', '41', '42', '43']
                            : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                    @endphp

                    @if($showSizeSelector)
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ $categoryId === 2 ? 'Chọn size giày:' : 'Chọn size áo:' }}
                        </label>
                        <div class="flex flex-wrap gap-2" id="size-container">
                            @foreach($sizeList as $size)
                                <button type="button"
                                        data-size="{{ $size }}"
                                        class="size-btn px-4 py-2 text-xs font-bold rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-orange-500 hover:text-orange-600 transition {{ $loop->first ? 'border-orange-500 bg-orange-50 text-orange-600' : '' }}">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <h3 class="text-sm font-bold text-gray-700 uppercase mb-2">Mô tả sản phẩm:</h3>
                        <div class="text-sm text-gray-600 leading-relaxed space-y-2">
                            {!! $sanPham->mo_ta ?? 'Đang cập nhật thông tin chi tiết cho sản phẩm này...' !!}
                        </div>
                    </div>
                </div>

                <!-- Form thêm vào giỏ hàng -->
                <form action="{{ route('cart.add', $sanPham->id) }}" method="POST">
                    @csrf
                    <!-- Biến thể ID sẽ tự động thay đổi theo nút bấm biến thể phía trên -->
                    <input type="hidden" name="bien_the_id" id="selected-bien-the-id" value="{{ $sanPham->bienThes->first()->id ?? $sanPham->id }}">
                    @if($showSizeSelector)
                        <input type="hidden" name="size" id="selected-size" value="{{ $sizeList[0] }}">
                    @endif
                    
                    <div class="flex items-center gap-4 mb-4">
                        <!-- Chọn số lượng -->
                        <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden">
                            <button type="button" id="decrease-qty" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 transition">-</button>
                            <input type="number" name="so_luong" id="quantity-input" value="1" min="1" class="w-12 text-center text-sm font-bold focus:outline-none">
                            <button type="button" id="increase-qty" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 transition">+</button>
                        </div>

                        <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-md cursor-pointer text-xs uppercase tracking-wider">
                            <i class="fa-solid fa-bag-shopping mr-2"></i> Thêm vào giỏ hàng
                        </button>
                    </div>
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
                            @php
                                $relatedImage = \App\Models\SanPham::resolveImageName($item->anh_dai_dien ?? null);
                            @endphp
                            <img src="{{ asset('images/' . $relatedImage) }}"
                                 class="h-full w-full object-contain"
                                 alt="{{ $item->ten_san_pham }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/yonex_doura10.webp') }}';">
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

    <!-- Script xử lý tăng giảm số lượng & chọn biến thể -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Xử lý nút tăng giảm số lượng
            const qtyInput = document.getElementById('quantity-input');
            const decreaseBtn = document.getElementById('decrease-qty');
            const increaseBtn = document.getElementById('increase-qty');

            decreaseBtn.addEventListener('click', function () {
                let currentVal = parseInt(qtyInput.value) || 1;
                if (currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                }
            });

            increaseBtn.addEventListener('click', function () {
                let currentVal = parseInt(qtyInput.value) || 1;
                qtyInput.value = currentVal + 1;
            });

            // Xử lý chọn biến thể sản phẩm
            const variantBtns = document.querySelectorAll('.variant-btn');
            const sizeBtns = document.querySelectorAll('.size-btn');
            const hiddenVariantInput = document.getElementById('selected-bien-the-id');
            const hiddenSizeInput = document.getElementById('selected-size');
            const productPriceEl = document.getElementById('product-price');

            variantBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Cập nhật giao diện active cho nút bấm
                    variantBtns.forEach(b => {
                        b.classList.remove('border-orange-500', 'bg-orange-50', 'text-orange-600');
                        b.classList.add('border-gray-200', 'bg-white', 'text-gray-700');
                    });
                    this.classList.remove('border-gray-200', 'bg-white', 'text-gray-700');
                    this.classList.add('border-orange-500', 'bg-orange-50', 'text-orange-600');

                    // Lấy giá trị id biến thể và giá tiền tương ứng
                    const variantId = this.getAttribute('data-id');
                    const variantPrice = parseFloat(this.getAttribute('data-price'));

                    // Gán vào input ẩn để gửi lên server khi submit form giỏ hàng
                    hiddenVariantInput.value = variantId;

                    // Cập nhật lại giá tiền hiển thị trên màn hình
                    if (!isNaN(variantPrice)) {
                        productPriceEl.textContent = new Intl.NumberFormat('vi-VN').format(variantPrice) + ' VNĐ';
                    }
                });
            });

            sizeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    sizeBtns.forEach(b => {
                        b.classList.remove('border-orange-500', 'bg-orange-50', 'text-orange-600');
                        b.classList.add('border-gray-200', 'bg-white', 'text-gray-700');
                    });
                    this.classList.remove('border-gray-200', 'bg-white', 'text-gray-700');
                    this.classList.add('border-orange-500', 'bg-orange-50', 'text-orange-600');
                    hiddenSizeInput.value = this.getAttribute('data-size');
                });
            });
        });
    </script>
    @include('partials.cart-ajax')
</body>
</html>