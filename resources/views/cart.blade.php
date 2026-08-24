<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xs font-bold text-orange-500 flex items-center gap-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
            <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON PRO</a>
            <div></div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-black text-slate-900 mb-6 uppercase">Giỏ hàng của bạn</h1>

        <!-- Thông báo thành công / lỗi nếu có -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-sm font-bold flex items-center shadow-sm">
                <i class="fa-solid fa-check-circle mr-2 text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl text-sm font-bold flex items-center shadow-sm">
                <i class="fa-solid fa-triangle-exclamation mr-2 text-lg"></i> {{ session('error') }}
            </div>
        @endif

        @php
            $totalAmount = 0;
        @endphp

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Danh sách sản phẩm trong giỏ -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 divide-y divide-gray-100">
                            @foreach($cart as $id => $item)
                                @php
                                    $subtotal = $item['gia'] * $item['so_luong'];
                                    $totalAmount += $subtotal;
                                @endphp
                                <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    
                                    <!-- Hình ảnh & Tên sản phẩm -->
                                    <div class="flex items-center space-x-4 w-full sm:w-auto">
                                        <div class="w-20 h-20 bg-gray-50 rounded-xl p-2 flex items-center justify-center shrink-0 border border-gray-100">
                                            <img src="{{ asset('images/' . ($item['anh'] ?? 'yonex_doura10.webp')) }}" 
                                                 onerror="this.onerror=null; this.src='{{ asset('images/yonex_doura10.webp') }}';"
                                                 class="h-full object-contain" alt="{{ $item['ten'] }}">
                                        </div>
                                        <div>
                                            <h3 class="text-xs font-bold text-gray-800 line-clamp-2">{{ $item['ten'] }}</h3>
                                            <p class="text-xs font-bold text-orange-500 mt-1">{{ number_format($item['gia'], 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>

                                    <!-- Cập nhật số lượng & Xóa -->
                                    <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4">
                                        <!-- Form cập nhật số lượng -->
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="so_luong" value="{{ $item['so_luong'] }}" min="1" 
                                                   class="w-14 text-center text-xs border border-gray-300 rounded-lg py-1.5 focus:outline-none focus:border-orange-500 mr-2"
                                                   onchange="this.form.submit()">
                                        </form>

                                        <!-- Tổng tiền của sản phẩm này -->
                                        <span class="text-xs font-black text-slate-900 w-28 text-right">
                                            {{ number_format($subtotal, 0, ',', '.') }} VNĐ
                                        </span>

                                        <!-- Nút xóa sản phẩm -->
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

                <!-- Bảng tổng kết đơn hàng (Checkout Summary) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-20">
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase mb-4 pb-2 border-b border-gray-100">Cộng giỏ hàng</h2>
                        
                        <div class="space-y-3 text-xs mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span class="font-bold text-slate-900">{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Phí vận chuyển</span>
                                <span class="font-bold text-green-600">Miễn phí</span>
                            </div>
                            <div class="border-t border-gray-100 pt-3 flex justify-between text-sm font-extrabold text-slate-900">
                                <span>Tổng cộng</span>
                                <span class="text-orange-500">{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</span>
                            </div>
                        </div>

                        <!-- Nút tiến hành thanh toán -->
                        <a href="{{ route('checkout') }}" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md text-xs uppercase">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>

            </div>
        @else
            <!-- Giao diện khi giỏ hàng trống -->
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

</body>
</html>