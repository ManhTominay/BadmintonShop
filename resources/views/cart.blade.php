<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xs font-bold text-orange-500 flex items-center gap-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
            <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON PRO</a>
            <div></div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-black text-slate-900 mb-6 uppercase">Giỏ hàng của bạn</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-sm font-bold flex items-center shadow-sm">
                <i class="fa-solid fa-check-circle mr-2 text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if(isset($cart) && count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between text-xs font-bold text-gray-700">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="w-4 h-4 text-orange-500 rounded border-gray-300 focus:ring-orange-500 cursor-pointer mr-3">
                                <label for="select-all" class="cursor-pointer select-none uppercase tracking-wider">Chọn tất cả sản phẩm</label>
                            </div>

                            <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600 font-bold uppercase tracking-wider">
                                    Xóa tất cả
                                </button>
                            </form>
                        </div>

                        <div class="p-6 divide-y divide-gray-100">
                            @foreach($cart as $id => $item)
                                @php
                                    $gia = $item['gia'];
                                    $soLuong = $item['so_luong'];
                                    $subtotal = $gia * $soLuong;
                                @endphp
                                <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-center justify-between gap-4 cart-item" 
                                     data-id="{{ $id }}" 
                                     data-price="{{ $gia }}">
                                    
                                    <div class="flex items-center space-x-4 w-full sm:w-auto">
                                        <input type="checkbox" name="selected_items[]" value="{{ $id }}" 
                                               class="product-checkbox w-4 h-4 text-orange-500 rounded border-gray-300 focus:ring-orange-500 cursor-pointer shrink-0">

                                        <div class="w-20 h-20 bg-gray-50 rounded-xl p-2 flex items-center justify-center shrink-0 border border-gray-100">
                                            <img src="{{ asset('images/' . ($item['anh'] ?? 'yonex_doura10.webp')) }}" 
                                                 onerror="this.onerror=null; this.src='{{ asset('images/yonex_doura10.webp') }}';"
                                                 class="h-full object-contain" alt="{{ $item['ten'] }}">
                                        </div>
                                        <div>
                                            <h3 class="text-xs font-bold text-gray-800 line-clamp-2">{{ $item['ten'] }}</h3>
                                            @if(!empty($item['size']))
                                                <p class="text-[10px] font-bold text-slate-600 mt-1">Size: {{ $item['size'] }}</p>
                                            @endif
                                            <p class="text-xs font-bold text-orange-500 mt-1">{{ number_format($gia, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4">
                                        <div class="flex items-center">
                                            <input type="number" value="{{ $soLuong }}" min="1" 
                                                   class="qty-input w-14 text-center text-xs border border-gray-300 rounded-lg py-1.5 focus:outline-none focus:border-orange-500 mr-2">
                                        </div>

                                        <span class="text-xs font-black text-slate-900 w-28 text-right item-total-price">
                                            {{ number_format($subtotal, 0, ',', '.') }} VNĐ
                                        </span>

                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2" title="Xóa sản phẩm">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-20">
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase mb-4 pb-2 border-b border-gray-100">Cộng giỏ hàng</h2>
                        
                        <div class="space-y-3 text-xs mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span id="cart-subtotal" class="font-bold text-slate-900">0 VNĐ</span>
                            </div>
                            
                            <div class="border-t border-gray-100 pt-3 flex justify-between text-sm font-extrabold text-slate-900">
                                <span>Tổng cộng</span>
                                <span id="cart-total" class="text-orange-500">0 VNĐ</span>
                            </div>
                        </div>

                        <!-- Thêm id="checkout-btn" để dễ quản lý sự kiện click -->
                        <button type="button" id="checkout-btn" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md text-xs uppercase cursor-pointer">
                            Tiến hành thanh toán
                        </button>
                    </div>
                </div>

            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-2">Giỏ hàng của bạn đang trống</h2>
                <p class="text-xs text-gray-500 mb-6">Hãy khám phá thêm các sản phẩm vợt và phụ kiện cầu lông tuyệt vời của chúng tôi nhé!</p>
                <a href="{{ url('/') }}" class="inline-block bg-slate-900 text-white text-xs font-bold px-6 py-3 rounded-xl hover:bg-orange-500 transition">
                    MUA SẮM NGAY
                </a>
            </div>
        @endif
    </main>

    <script>
        // Đưa hàm ra phạm vi toàn cục để dự phòng mọi trường hợp gọi
        window.checkoutSelected = function() {
            const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
            const selectedIds = [];

            selectedCheckboxes.forEach(cb => {
                selectedIds.push(cb.value);
            });

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
                return;
            }

            // Chuyển hướng trực tiếp sang trang checkout
            window.location.href = "/thanh-toan?items=" + selectedIds.join(',');
        };

        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const qtyInputs = document.querySelectorAll('.qty-input');
            const subtotalEl = document.getElementById('cart-subtotal');
            const totalEl = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-btn');

            // Gắn sự kiện click trực tiếp qua JS cho nút thanh toán
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.checkoutSelected();
                });
            }

            function updateSummary() {
                let total = 0;
                productCheckboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        const itemRow = checkbox.closest('.cart-item');
                        const price = parseFloat(itemRow.getAttribute('data-price')) || 0;
                        const qty = parseInt(itemRow.querySelector('.qty-input').value) || 1;
                        total += price * qty;
                    }
                });

                const formattedTotal = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
                if (subtotalEl) subtotalEl.textContent = formattedTotal;
                if (totalEl) totalEl.textContent = formattedTotal;
            }

            qtyInputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (this.value < 1) this.value = 1;
                    const itemRow = this.closest('.cart-item');
                    const price = parseFloat(itemRow.getAttribute('data-price')) || 0;
                    const qty = parseInt(this.value) || 1;
                    
                    const itemTotal = price * qty;
                    itemRow.querySelector('.item-total-price').textContent = new Intl.NumberFormat('vi-VN').format(itemTotal) + ' VNĐ';

                    updateSummary();

                    const cartId = itemRow.getAttribute('data-id');
                    updateCartDatabase(cartId, qty);
                });
            });

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function () {
                    productCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSummary();
                });
            }

            productCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    let allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                    if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
                    updateSummary();
                });
            });

            updateSummary();
        });

        function updateCartDatabase(id, quantity) {
            axios.patch('/gio-hang/cap-nhat/' + id, {
                so_luong: quantity,
                _token: '{{ csrf_token() }}'
            }).catch(error => {
                console.error("Lỗi đồng bộ giỏ hàng:", error);
            });
        }
    </script>
</body>
</html>