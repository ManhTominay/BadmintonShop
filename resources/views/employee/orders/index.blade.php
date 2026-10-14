<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Badminton Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 flex h-screen overflow-hidden">
    <aside class="w-64 bg-[#0b0b0b] text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-orange-900/40">
                <h1 class="text-lg font-bold tracking-wider">BADMINTON</h1>
                <p class="text-xs text-gray-400">Employee Panel</p>
            </div>
            <nav class="p-4 space-y-1" aria-label="Điều hướng nhân viên">
                <a href="{{ route('employee.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-shopping-cart w-5"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
                <a href="{{ route('employee.support.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-orange-950/60 hover:text-orange-100 text-sm font-medium">
                    <i class="fa-solid fa-headset w-5"></i>
                    <span>Hỗ trợ khách hàng</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-orange-900/40 space-y-2">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 text-xs text-orange-200/70 hover:text-orange-100">
                <i class="fa-solid fa-globe"></i> Về giao diện user
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-orange-950/70 text-orange-300 rounded hover:bg-orange-900/80 hover:text-orange-100 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Quản lý đơn hàng</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Nhân viên: <strong class="text-gray-900">{{ Auth::user()->ho_ten }}</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">NV</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="max-w-7xl mx-auto flex flex-col">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Danh sách đơn hàng</h1>
                </div>

                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif
                @if($errors->has('trang_thai'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first('trang_thai') }}</div>
                @endif

                <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4">
                    <p class="mb-3 text-sm font-semibold text-gray-700">Lọc theo trạng thái đơn hàng</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('employee.orders.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ !$selectedStatus ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
                            Tất cả <span class="ml-1 text-xs opacity-75">({{ $statusCounts->sum() }})</span>
                        </a>
                        @foreach($statusOptions as $statusKey => $statusLabel)
                            <a href="{{ route('employee.orders.index', ['status' => $statusKey]) }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ $selectedStatus === $statusKey ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
                                {{ $statusLabel }} <span class="ml-1 text-xs opacity-75">({{ $statusCounts[$statusKey] ?? 0 }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div id="orders" class="mt-8 overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="w-full min-w-[760px] border-collapse text-left text-sm text-gray-600">
                        <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="p-4 font-semibold">Mã đơn</th>
                                <th class="p-4 font-semibold">Khách hàng</th>
                                <th class="p-4 font-semibold">Tổng tiền</th>
                                <th class="p-4 font-semibold">Trạng thái</th>
                                <th class="p-4 text-center font-semibold">Thao tác</th>
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
                                        'tra_hang' => ['Chờ hoàn tiền', 'bg-purple-100 text-purple-800'],
                                        'hoan_tien' => ['Đã hoàn tiền', 'bg-green-100 text-green-800'],
                                    ];
                                    [$statusLabel, $statusClass] = $statusLabels[$order->trang_thai_don_hang] ?? ['Chờ xác nhận', 'bg-yellow-100 text-yellow-800'];
                                @endphp
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 font-medium text-gray-900">#{{ $order->ma_don_hang ?? $order->id }}</td>
                                    <td class="p-4">{{ $order->ten_nguoi_nhan ?? 'Khách lẻ' }}</td>
                                    <td class="p-4 font-semibold text-orange-600">{{ number_format($order->tong_thanh_toan ?? $order->tong_tien_hang ?? 0, 0, ',', '.') }} đ</td>
                                    <td class="p-4"><span class="rounded px-2 py-1 text-xs {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                    <td class="p-4 text-center">
                                        @if($order->trang_thai_don_hang === 'cho_xu_ly')
                                            <form action="{{ route('employee.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="trang_thai" value="dang_giao">
                                                <button type="submit" class="rounded-lg bg-orange-50 px-3 py-2 font-medium text-orange-600 hover:bg-orange-100 hover:text-orange-800"><i class="fa-solid fa-check mr-1"></i>Xác nhận đơn</button>
                                            </form>
                                        @elseif($order->trang_thai_don_hang === 'dang_giao')
                                            <form action="{{ route('employee.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="trang_thai" value="cho_giao_hang">
                                                <button type="submit" class="font-medium text-blue-600 hover:text-blue-800"><i class="fa-solid fa-truck-fast mr-1"></i>Giao cho ship</button>
                                            </form>
                                        @elseif($order->trang_thai_don_hang === 'cho_giao_hang')
                                            <span class="font-medium text-blue-600"><i class="fa-solid fa-truck mr-1"></i>Chờ khách xác nhận</span>
                                        @else
                                            <span class="text-gray-400">Đã xử lý</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-8 text-center italic text-gray-400">Chưa có đơn hàng nào trong hệ thống.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $orders->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>