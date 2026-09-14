<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Badminton Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar bên trái -->
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
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-orange-950/70 text-orange-300 rounded hover:bg-orange-900/80 hover:text-orange-100 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Khu vực nội dung bên phải -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Hệ thống quản trị</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Xin chào, <strong class="text-gray-900">Quản Trị Viên</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">QU</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            @yield('content')
        </main>
    </div>

</body>
</html>