<nav class="p-4 space-y-1" aria-label="Điều hướng quản trị">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard*') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-chart-pie w-5"></i>
        <span>Báo cáo thống kê</span>
    </a>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.products*') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-box w-5"></i>
        <span>Quản lý sản phẩm</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-shopping-cart w-5"></i>
        <span>Quản lý đơn hàng</span>
    </a>
    <a href="{{ route('admin.orders.cancellationReasons') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.orders.cancellationReasons') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-ban w-5"></i>
        <span>Lý do hủy đơn</span>
    </a>
    <a href="{{ route('admin.vouchers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.vouchers*') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-ticket w-5"></i>
        <span>Quản lý voucher</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users*') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-orange-950/60 hover:text-orange-100' }}">
        <i class="fa-solid fa-users w-5"></i>
        <span>Quản lý tài khoản</span>
    </a>
</nav>
