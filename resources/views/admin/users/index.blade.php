<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản - Badminton Admin</title>
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
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-orange-950/70 text-orange-300 rounded hover:bg-orange-900/80 hover:text-orange-100 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Nội dung chính bên phải -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Quản lý tài khoản</div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Xin chào, <strong class="text-gray-900">Quản Trị Viên</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">QU</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Danh sách người dùng</h2>
                    <a href="{{ route('admin.users.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Thêm tài khoản mới
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="search" name="search" value="{{ $search }}" placeholder="Tìm theo tên, email, số điện thoại hoặc mã tài khoản..." class="w-full rounded-lg border border-gray-200 py-2.5 pl-11 pr-4 text-sm text-gray-700 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                        </div>
                        <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i>Tìm kiếm
                        </button>
                        @if($search !== '')
                            <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-gray-200 px-5 py-2.5 text-center text-sm font-semibold text-gray-600 transition hover:border-orange-500 hover:text-orange-600">
                                Xóa tìm kiếm
                            </a>
                        @endif
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full border-collapse text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="p-4 font-semibold text-center w-16">ID</th>
                                <th class="p-4 font-semibold">Tên người dùng</th>
                                <th class="p-4 font-semibold">Email</th>
                                <th class="p-4 font-semibold">Hoạt động cuối</th>
                                <th class="p-4 font-semibold text-center w-32">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users ?? [] as $user)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 text-center font-medium text-gray-900">#{{ $user->id }}</td>
                                    <td class="p-4 font-medium text-gray-900">{{ $user->name ?? $user->ho_ten }}</td>
                                    <td class="p-4">{{ $user->email }}</td>
                                    <td class="p-4 text-gray-500">{{ $user->last_activity_at ?? 'Chưa có' }}</td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Sửa</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 italic">{{ $search !== '' ? 'Không tìm thấy tài khoản phù hợp.' : 'Chưa có người dùng nào trong hệ thống.' }}</td>
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