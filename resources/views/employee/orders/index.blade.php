<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 flex h-screen overflow-hidden">
    <aside class="w-64 bg-[#0f172a] text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-gray-800">
                <h1 class="text-lg font-bold tracking-wider">BADMINTON</h1>
                <p class="text-xs text-gray-400">Employee Panel</p>
            </div>
            <nav class="p-4">
                <a href="{{ route('employee.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-clipboard-list w-5"></i> Quản lý đơn hàng
                </a>
                <a href="{{ route('employee.support.index') }}" class="mt-2 flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-headset w-5"></i> Hỗ trợ khách hàng
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-800 space-y-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white">
                <i class="fa-solid fa-globe"></i> Về giao diện user
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-red-900/40 text-red-400 rounded hover:bg-red-900/60 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Quản lý đơn hàng</div>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-500">Nhân viên: <strong class="text-gray-900">{{ Auth::user()->ho_ten }}</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">NV</div>
            </div>
        </header>

    <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h1>
                <p class="text-sm text-gray-500 mt-1">Theo dõi và cập nhật trạng thái đơn hàng của cửa hàng.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
            <table class="w-full min-w-[760px] border-collapse text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="p-4 font-semibold">Mã đơn</th>
                        <th class="p-4 font-semibold">Khách hàng</th>
                        <th class="p-4 font-semibold">Tổng tiền</th>
                        <th class="p-4 font-semibold">Trạng thái</th>
                        <th class="p-4 font-semibold text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        @php
                            $statusLabels = [
                                'cho_xu_ly' => ['Chờ xác nhận', 'bg-yellow-100 text-yellow-800'],
                                'dang_giao' => ['Đang giao', 'bg-blue-100 text-blue-800'],
                                'cho_giao_hang' => ['Chờ giao hàng', 'bg-indigo-100 text-indigo-800'],
                                'hoan_thanh' => ['Hoàn thành', 'bg-green-100 text-green-800'],
                                'da_huy' => ['Đã hủy', 'bg-red-100 text-red-800'],
                                'tra_hang' => ['Trả hàng', 'bg-purple-100 text-purple-800'],
                                'hoan_tien' => ['Hoàn tiền', 'bg-purple-100 text-purple-800'],
                            ];
                            [$statusLabel, $statusClass] = $statusLabels[$order->trang_thai_don_hang] ?? ['Chờ xác nhận', 'bg-yellow-100 text-yellow-800'];
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-900">#{{ $order->ma_don_hang ?? $order->id }}</td>
                            <td class="p-4">{{ $order->ten_nguoi_nhan ?? 'Khách lẻ' }}</td>
                            <td class="p-4 font-semibold text-orange-600">{{ number_format($order->tong_thanh_toan ?? $order->tong_tien_hang ?? 0, 0, ',', '.') }} đ</td>
                            <td class="p-4"><span class="rounded px-2 py-1 text-xs {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td class="p-4 text-center">
                                @if($order->trang_thai_don_hang === 'cho_xu_ly')
                                    <form action="{{ route('employee.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="trang_thai" value="dang_giao">
                                        <button type="submit" class="font-medium text-orange-600 hover:text-orange-800">Xác nhận đơn</button>
                                    </form>
                                @elseif($order->trang_thai_don_hang === 'dang_giao')
                                    <form action="{{ route('employee.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="trang_thai" value="cho_giao_hang">
                                        <button type="submit" class="font-medium text-blue-600 hover:text-blue-800">Giao cho ship</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">Đã xử lý</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-gray-400 italic">Chưa có đơn hàng nào trong hệ thống.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $orders->links() }}</div>

    </main>
    </div>
</body>
</html>