<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê - Badminton Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <div class="w-64 bg-[#0b0b0b] text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-orange-900/40">
                <h1 class="text-lg font-bold tracking-wider">BADMINTON ADMIN</h1>
                <p class="text-xs text-gray-400">Management Panel</p>
            </div>
            @include('admin.layouts.sidebar')
        </div>
        <div class="p-4 border-t border-orange-900/40 space-y-2">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 text-xs text-orange-200/70 hover:text-orange-100">
                <i class="fa-solid fa-globe"></i> Xem website chính
            </a>
            <form action="{{ url('/admin/logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-orange-950/70 text-orange-300 rounded hover:bg-orange-900/80 hover:text-orange-100 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất Admin
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Báo cáo thống kê</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Xin chào, <strong class="text-gray-900">Quản Trị Viên</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">QU</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Báo cáo thống kê tổng quan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Tổng sản phẩm</p>
                            <span class="text-xl text-blue-500"><i class="fa-solid fa-box"></i></span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mt-3">{{ number_format($tongSoSanPham ?? 0) }}</h3>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
                            <span class="text-xl text-orange-500"><i class="fa-solid fa-cart-shopping"></i></span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mt-3">{{ number_format($tongDonHang ?? 0) }}</h3>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Thành viên</p>
                            <span class="text-xl text-green-500"><i class="fa-solid fa-users"></i></span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mt-3">{{ number_format($tongSoNguoiDung ?? 0) }}</h3>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Doanh thu</p>
                            <span class="text-xl text-red-500"><i class="fa-solid fa-wallet"></i></span>
                        </div>
                        <h3 class="text-3xl font-bold text-orange-600 mt-3">{{ number_format($tongDoanhThu ?? 0, 0, ',', '.') }} đ</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Doanh thu hôm nay</p>
                        <h3 class="text-2xl font-bold text-green-600 mt-2">{{ number_format($doanhThuHomNay ?? 0, 0, ',', '.') }} đ</h3>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Doanh thu 7 ngày</p>
                        <h3 class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($doanhThu7Ngay ?? 0, 0, ',', '.') }} đ</h3>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Doanh thu tháng này</p>
                        <h3 class="text-2xl font-bold text-purple-600 mt-2">{{ number_format($doanhThuThangNay ?? 0, 0, ',', '.') }} đ</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 xl:col-span-2">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-lg font-bold text-gray-800">Doanh thu theo 7 ngày gần nhất</h3>
                            <span class="text-xs font-medium text-gray-500">Từ đơn hàng đã thanh toán</span>
                        </div>

                        @php
                            $maxRevenue = collect($revenueByDay ?? [])->max('doanh_thu') ?? 0;
                        @endphp

                        <div class="flex items-end gap-3 h-52">
                            @foreach ($revenueByDay ?? [] as $day)
                                @php
                                    $height = $maxRevenue > 0 ? max(12, ($day->doanh_thu / $maxRevenue) * 100) : 0;
                                    $label = \Carbon\Carbon::parse($day->ngay)->format('d/m');
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-2">
                                    <div class="w-full flex items-end justify-center h-40">
                                        <div class="w-full rounded-t-lg bg-gradient-to-t from-orange-500 to-orange-300" style="height: {{ $height }}%; min-height: 8px;"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $label }}</span>
                                    <span class="text-[10px] text-gray-400">{{ number_format($day->doanh_thu ?? 0, 0, ',', '.') }}đ</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-5">Trạng thái đơn hàng</h3>
                        @php $totalStatus = max(1, collect($statusCounts ?? [])->sum('total')); @endphp
                        @foreach ($statusCounts ?? [] as $status)
                            @php
                                $label = $statusLabels[$status->trang_thai_don_hang] ?? ucfirst(str_replace('_', ' ', $status->trang_thai_don_hang ?? '')); 
                                $percent = ($status->total / $totalStatus) * 100;
                            @endphp
                            <div class="mb-4">
                                <div class="flex justify-between mb-1 text-sm">
                                    <span class="text-gray-700">{{ $label }}</span>
                                    <span class="font-semibold text-gray-900">{{ $status->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full bg-orange-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-5">Phương thức thanh toán</h3>
                        @php $totalPayment = max(1, collect($paymentCounts ?? [])->sum('total')); @endphp
                        @foreach ($paymentCounts ?? [] as $payment)
                            @php
                                $label = $paymentLabels[$payment->phuong_thuc_thanh_toan] ?? $payment->phuong_thuc_thanh_toan;
                                $percent = ($payment->total / $totalPayment) * 100;
                            @endphp
                            <div class="mb-4">
                                <div class="flex justify-between mb-1 text-sm">
                                    <span class="text-gray-700">{{ $label }}</span>
                                    <span class="font-semibold text-gray-900">{{ $payment->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full bg-green-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-5">Top sản phẩm bán chạy</h3>
                        <div class="space-y-4">
                            @forelse ($bestProducts ?? [] as $index => $product)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 border border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $product->ten_san_pham }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($product->so_luong_ban ?? 0) }} sản phẩm đã bán</p>
                                    </div>
                                    <span class="font-bold text-orange-600">{{ number_format($product->doanh_thu ?? 0, 0, ',', '.') }} đ</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Chưa có dữ liệu sản phẩm bán chạy.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-5">Đơn hàng gần đây</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-600">
                                    <th class="py-3 pr-4 font-semibold">Mã đơn</th>
                                    <th class="py-3 pr-4 font-semibold">Khách hàng</th>
                                    <th class="py-3 pr-4 font-semibold">Phương thức</th>
                                    <th class="py-3 pr-4 font-semibold">Tổng tiền</th>
                                    <th class="py-3 pr-4 font-semibold">Trạng thái</th>
                                    <th class="py-3 pr-4 font-semibold">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders ?? [] as $order)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 pr-4 font-medium text-gray-800">{{ $order->ma_don_hang ?? '---' }}</td>
                                        <td class="py-3 pr-4 text-gray-700">{{ $order->ten_nguoi_mua ?? 'Khách hàng' }}</td>
                                        <td class="py-3 pr-4 text-gray-700">{{ $paymentLabels[$order->phuong_thuc_thanh_toan] ?? $order->phuong_thuc_thanh_toan ?? '---' }}</td>
                                        <td class="py-3 pr-4 font-semibold text-orange-600">{{ number_format($order->tong_thanh_toan ?? 0, 0, ',', '.') }} đ</td>
                                        <td class="py-3 pr-4">
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                {{ $statusLabels[$order->trang_thai_don_hang] ?? ucfirst(str_replace('_', ' ', $order->trang_thai_don_hang ?? '')) }}
                                            </span>
                                        </td>
                                        <td class="py-3 pr-4 text-gray-600">{{ $order->ngay_tao ? \Carbon\Carbon::parse($order->ngay_tao)->format('d/m/Y H:i') : '---' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>