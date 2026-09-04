<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - Badminton Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar bên trái -->
    <div class="w-64 bg-[#0f172a] text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-gray-800">
                <h1 class="text-lg font-bold tracking-wider">BADMINTON ADMIN</h1>
                <p class="text-xs text-gray-400">Management Panel</p>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-chart-pie w-5"></i> Báo cáo thống kê
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-box w-5"></i> Quản lý sản phẩm
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-shopping-cart w-5"></i> Quản lý đơn hàng
                </a>
                <a href="{{ url('/admin/users') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-users w-5"></i> Quản lý tài khoản
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-800 space-y-2">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white">
                <i class="fa-solid fa-globe"></i> Xem website chính
            </a>
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-red-900/40 text-red-400 rounded hover:bg-red-900/60 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Nội dung chính bên phải -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Quản lý đơn hàng</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Xin chào, <strong class="text-gray-900">Quản Trị Viên</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">QU</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Danh sách đơn hàng</h2>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full border-collapse text-left text-sm text-gray-600">
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
                            @forelse($orders ?? [] as $order)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="p-4">{{ $order->ten_khach_hang ?? 'Khách lẻ' }}</td>
                                    <td class="p-4 font-semibold text-orange-600">{{ number_format($order->tong_tien ?? 0) }} đ</td>
                                    <td class="p-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Chờ xử lý</span></td>
                                    <td class="p-4 text-center">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Chi tiết</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 italic">Chưa có đơn hàng nào trong hệ thống.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>