<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê - Badminton Admin</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-chart-pie w-5"></i> Báo cáo thống kê
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-box w-5"></i> Quản lý sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-shopping-cart w-5"></i> Quản lý đơn hàng
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-ticket w-5"></i> Quản lý voucher
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
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

                <!-- Thẻ thống kê nhanh -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Tổng sản phẩm</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Thành viên hệ thống</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Tổng doanh thu</p>
                        <h3 class="text-3xl font-bold text-orange-600 mt-2">{{ number_format($totalRevenue ?? 0) }} đ</h3>
                    </div>
                </div>

                <!-- Khu vực nội dung biểu đồ / bảng thống kê -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Biểu đồ tổng quan hoạt động</h3>
                    <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border border-dashed border-gray-300 text-gray-400 italic">
                        Khu vực hiển thị biểu đồ thống kê hệ thống
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>