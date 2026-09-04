<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm - Badminton Admin</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-chart-pie w-5"></i> Báo cáo thống kê
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-box w-5"></i> Quản lý sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-shopping-cart w-5"></i> Quản lý đơn hàng
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
            <form action="{{ route('logout') }}" method="POST">
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
            <div class="text-sm font-semibold text-gray-700">Quản lý sản phẩm</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Xin chào, <strong class="text-gray-900">Quản Trị Viên</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">QU</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa thông tin sản phẩm</h2>

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tên sản phẩm -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm</label>
                        <input type="text" name="ten_san_pham" value="{{ old('ten_san_pham', $product->ten_san_pham ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>

                    <!-- Giá cơ bản -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Giá cơ bản</label>
                        <input type="number" name="gia_co_ban" value="{{ old('gia_co_ban', $product->gia_co_ban ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng</label>
                        <input type="number" name="so_luong" value="{{ old('so_luong', $product->so_luong ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>

                    <!-- Ảnh đại diện -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện mới (nếu muốn thay đổi)</label>
                        @if($product->anh_dai_dien)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->anh_dai_dien) }}" alt="Ảnh sản phẩm" class="w-20 h-20 object-cover rounded border">
                            </div>
                        @endif
                        <input type="file" name="anh_dai_dien" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold">Hủy</a>
                        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-semibold hover:bg-orange-700">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>