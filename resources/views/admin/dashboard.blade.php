<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR NAVIGATION -->
        <aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col justify-between">
            <div>
                <!-- Logo Admin -->
                <div class="p-5 border-b border-slate-800 flex items-center space-x-2">
                    <i class="fa-solid fa-shuttlecock text-2xl text-orange-500"></i>
                    <div>
                        <h1 class="font-extrabold text-sm uppercase tracking-wider">BADMINTON ADMIN</h1>
                        <p class="text-[10px] text-gray-400">Management Panel</p>
                    </div>
                </div>

                <!-- Menu Links -->
                <nav class="p-4 space-y-1 text-xs font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-orange-500 text-white transition">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Báo cáo thống kê</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-box-archive w-5"></i>
                        <span>Quản lý sản phẩm</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-cart-shopping w-5"></i>
                        <span>Quản lý đơn hàng</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-users-gear w-5"></i>
                        <span>Quản lý tài khoản</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-slate-800">
                <a href="{{ url('/') }}" target="_blank" class="flex items-center space-x-2 text-xs text-gray-400 hover:text-white transition mb-3">
                    <i class="fa-solid fa-globe"></i>
                    <span>Xem website chính</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white text-xs font-bold py-2 px-3 rounded transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Đăng xuất Admin</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <div class="flex items-center space-x-3">
                    <button class="md:hidden text-gray-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h2 class="font-extrabold text-sm uppercase text-slate-800">Tổng quan hệ thống</h2>
                </div>

                <!-- Admin Profile info -->
                <div class="flex items-center space-x-4">
                    <span class="text-xs text-gray-500">Xin chào, <strong class="text-slate-800">{{ auth()->user()->ho_ten ?? 'ManhTominay' }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ strtoupper(substr(auth()->user()->ho_ten ?? 'MT', 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- Dashboard Body -->
            <main class="p-6 space-y-6">
                
                <!-- Hiển thị thông báo thành công / lỗi -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded text-xs font-bold">
                        <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-xs font-bold">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- PHẦN 1: BÁO CÁO THỐNG KÊ (Cards Dữ Liệu Thực Tế) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1: Doanh thu -->
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase">Tổng doanh thu</p>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-1">{{ number_format($tongDoanhThu ?? 0, 0, ',', '.') }} VNĐ</h3>
                            <span class="text-[10px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-arrow-up"></i> Thực tế hệ thống</span>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>

                    <!-- Card 2: Đơn hàng -->
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase">Tổng đơn hàng</p>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-1">{{ $tongDonHang ?? 0 }} đơn</h3>
                            <span class="text-[10px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-arrow-up"></i> Đã cập nhật</span>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                    </div>

                    <!-- Card 3: Sản phẩm -->
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase">Sản phẩm sẵn có</p>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-1">{{ $tongSoSanPham ?? 0 }} mặt hàng</h3>
                            <span class="text-[10px] text-gray-500 font-bold bg-gray-100 px-1.5 py-0.5 rounded">Đầy đủ chủng loại</span>
                        </div>
                        <div class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-table-tennis-paddle-ball"></i>
                        </div>
                    </div>

                    <!-- Card 4: Khách hàng / Tài khoản -->
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase">Tổng tài khoản</p>
                            <h3 class="text-lg font-extrabold text-slate-900 mt-1">{{ $tongSoNguoiDung ?? 0 }} thành viên</h3>
                            <span class="text-[10px] text-orange-600 font-bold bg-orange-50 px-1.5 py-0.5 rounded">Hoạt động tốt</span>
                        </div>
                        <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>

                </div>

                <!-- Biểu đồ phân tích doanh thu -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-extrabold text-xs uppercase text-slate-900">Biểu đồ tăng trưởng doanh thu (2026)</h3>
                            <span class="text-xs text-orange-500 font-bold cursor-pointer">Xem chi tiết</span>
                        </div>
                        <div class="h-64 flex items-end justify-between gap-2 pt-6 border-b border-gray-200 px-4">
                            <div class="w-full bg-gray-100 transition rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-gray-400 opacity-0 group-hover:opacity-100">0đ</span></div>
                            <div class="w-full bg-gray-100 transition rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-gray-400 opacity-0 group-hover:opacity-100">0đ</span></div>
                            <div class="w-full bg-gray-100 transition rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-gray-400 opacity-0 group-hover:opacity-100">0đ</span></div>
                            <div class="w-full bg-gray-100 transition rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-gray-400 opacity-0 group-hover:opacity-100">0đ</span></div>
                            <div class="w-full bg-gray-100 transition rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-gray-400 opacity-0 group-hover:opacity-100">0đ</span></div>
                            <div class="w-full bg-orange-100 rounded-t h-[0%] relative group flex justify-center"><span class="absolute -top-6 text-[10px] font-bold text-orange-600">0đ</span></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-gray-400 font-bold mt-2 px-2">
                            <span>Tháng 1</span><span>Tháng 2</span><span>Tháng 3</span><span>Tháng 4</span><span>Tháng 5</span><span>Tháng 6 (Hiện tại)</span>
                        </div>
                    </div>

                    <!-- Thống kê nhanh theo danh mục (Đã tách Quần áo và Phụ kiện riêng) -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col justify-between">
                        <h3 class="font-extrabold text-xs uppercase text-slate-900 mb-4">Danh mục bán chạy nhất</h3>
                        <div class="space-y-3 text-xs font-semibold">
                            <div>
                                <div class="flex justify-between mb-1"><span>Vợt Cầu Lông</span><span class="text-gray-400 font-bold">0%</span></div>
                                <div class="w-full bg-gray-100 h-2 rounded overflow-hidden"><div class="bg-orange-500 h-full w-[0%]"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1"><span>Giày Cầu Lông</span><span class="text-gray-400 font-bold">0%</span></div>
                                <div class="w-full bg-gray-100 h-2 rounded overflow-hidden"><div class="bg-blue-500 h-full w-[0%]"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1"><span>Quần Áo</span><span class="text-gray-400 font-bold">0%</span></div>
                                <div class="w-full bg-gray-100 h-2 rounded overflow-hidden"><div class="bg-green-500 h-full w-[0%]"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1"><span>Phụ Kiện</span><span class="text-gray-400 font-bold">0%</span></div>
                                <div class="w-full bg-gray-100 h-2 rounded overflow-hidden"><div class="bg-purple-500 h-full w-[0%]"></div></div>
                            </div>
                        </div>
                        <div class="bg-amber-50 p-3 rounded text-[11px] text-amber-800 border border-amber-200 mt-4">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> Hệ thống đang chờ phát sinh đơn hàng thực tế đầu tiên.
                        </div>
                    </div>
                </div>

                <!-- PHẦN 2: QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG (Đổ Dữ Liệu Từ Bảng nguoi_dung) -->
                <div id="quan-ly-tai-khoan" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="font-extrabold text-xs uppercase text-slate-900">Quản lý tài khoản người dùng</h3>
                            <p class="text-[11px] text-gray-400">Danh sách thành viên đăng ký và phân quyền hệ thống</p>
                        </div>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <input type="text" placeholder="Tìm kiếm tài khoản..." class="text-xs border border-gray-200 px-3 py-1.5 rounded focus:outline-none focus:border-orange-500 w-full sm:w-60">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-3 py-1.5 rounded transition flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-user-plus mr-1"></i> Thêm tài khoản
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 text-gray-500 uppercase border-b border-gray-100 font-bold">
                                <tr>
                                    <th class="p-4">ID</th>
                                    <th class="p-4">Họ tên</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Vai trò (Role)</th>
                                    <th class="p-4">Trạng thái</th>
                                    <th class="p-4 text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-bold text-slate-900">#{{ $user->id }}</td>
                                    <td class="p-4">{{ $user->ho_ten }}</td>
                                    <td class="p-4 text-gray-500">{{ $user->email }}</td>
                                    <td class="p-4">
                                        @if($user->vai_tro === 'admin')
                                            <span class="bg-red-50 text-red-600 px-2 py-0.5 rounded font-bold text-[10px]">Admin Hệ Thống</span>
                                        @else
                                            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded font-bold text-[10px]">Khách hàng</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <!-- Trạng thái Khoá / Hoạt động -->
                                        <div>
                                            @if($user->trang_thai == 1)
                                                <span class="text-green-600 font-bold"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Hoạt động</span>
                                            @else
                                                <span class="text-red-500 font-bold"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Đã khóa</span>
                                            @endif
                                        </div>

                                        <!-- Trạng thái Online / Offline dựa trên cột last_activity -->
                                        @php
                                            $isOnline = $user->last_activity && \Carbon\Carbon::parse($user->last_activity)->greaterThan(now()->subMinutes(5));
                                        @endphp
                                        <div class="mt-0.5">
                                            @if($isOnline)
                                                <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-signal text-[7px] mr-1"></i> Đang online</span>
                                            @else
                                                <span class="text-[10px] text-gray-400 font-semibold"><i class="fa-regular fa-clock text-[7px] mr-1"></i> Offline</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-bold inline-block"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                                        
                                        <!-- Form khóa / mở khóa tài khoản kết nối UserController -->
                                        <form action="{{ route('admin.users.lock', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="font-bold {{ $user->trang_thai == 1 ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }}">
                                                <i class="fa-solid {{ $user->trang_thai == 1 ? 'fa-lock' : 'fa-lock-open' }}"></i> {{ $user->trang_thai == 1 ? 'Khoá' : 'Mở khóa' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Chưa có tài khoản nào trong cơ sở dữ liệu.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>

    </div>

</body>
</html>