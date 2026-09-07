<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - Badminton Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <div class="w-64 bg-[#0f172a] text-white flex flex-col justify-between shrink-0">

        <div>

            <div class="p-5 border-b border-gray-800">
                <h1 class="text-lg font-bold tracking-wider">
                    BADMINTON ADMIN
                </h1>

                <p class="text-xs text-gray-400">
                    Management Panel
                </p>
            </div>

            <nav class="p-4 space-y-1">

                <a
                    href="{{ url('/admin/dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium"
                >
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    Báo cáo thống kê
                </a>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium"
                >
                    <i class="fa-solid fa-box w-5"></i>
                    Quản lý sản phẩm
                </a>

                <a
                    href="{{ route('admin.orders.index') }}#orders"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg"
                >
                    <i class="fa-solid fa-shopping-cart w-5"></i>
                    Quản lý đơn hàng
                </a>

                <a
                    href="{{ route('admin.vouchers.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.vouchers*') ? 'bg-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <i class="fa-solid fa-ticket w-5"></i>
                    Quản lý voucher
                </a>

                <a
                    href="{{ url('/admin/users') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium"
                >
                    <i class="fa-solid fa-users w-5"></i>
                    Quản lý tài khoản
                </a>

            </nav>
        </div>

        <div class="p-4 border-t border-gray-800 space-y-2">

            <a
                href="{{ url('/') }}"
                target="_blank"
                class="flex items-center gap-2 text-xs text-gray-400 hover:text-white"
            >
                <i class="fa-solid fa-globe"></i>
                Xem website chính
            </a>

            <form action="#" method="POST">
                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 bg-red-900/40 text-red-400 rounded hover:bg-red-900/60 text-xs font-medium"
                >
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Đăng xuất Admin
                </button>
            </form>

        </div>
    </div>


    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- HEADER -->
        <header
            class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0"
        >

            <div class="text-sm font-semibold text-gray-700">
                Quản lý đơn hàng
            </div>

            <div class="flex items-center gap-3">

                <span class="text-sm text-gray-600">
                    Xin chào,
                    <strong class="text-gray-900">
                        Quản Trị Viên
                    </strong>
                </span>

                <div
                    class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm"
                >
                    QU
                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">

            <div class="max-w-7xl mx-auto flex flex-col">

                <!-- TITLE -->
                <div class="mb-6">

                    @if(($section ?? 'orders') === 'orders')
                        <h2 class="text-2xl font-bold text-gray-800">
                            Danh sách đơn hàng
                        </h2>
                    @endif

                    <div class="mt-5">

                        @if(($section ?? 'orders') === 'vouchers')
                            <h2 class="text-2xl font-bold text-gray-800">
                                Quản lý voucher
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Tạo và cập nhật mã giảm giá cho khách hàng
                            </p>
                        @endif

                    </div>

                </div>


                <!-- ========================= -->
                <!-- THÊM VOUCHER -->
                <!-- ========================= -->

                @if(($section ?? 'orders') === 'vouchers')
                <section id="vouchers">

                    <form
                        action="{{ route('admin.vouchers.store') }}"
                        method="POST"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8"
                    >

                        @csrf

                        <div class="flex items-center gap-3 mb-5">

                            <div
                                class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center"
                            >
                                <i class="fa-solid fa-plus"></i>
                            </div>

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Thêm voucher
                                </h3>

                                <p class="text-xs text-gray-400">
                                    Tạo mã giảm giá mới cho khách hàng
                                </p>

                            </div>

                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                            <!-- MÃ -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Mã voucher
                                </span>

                                <input
                                    name="ma_code"
                                    required
                                    maxlength="50"
                                    placeholder="Ví dụ: GIAM10"
                                    class="mt-1 w-full border rounded-lg px-3 py-2 uppercase"
                                >

                                <span class="text-xs text-gray-400">
                                    Mã khách hàng nhập khi mua hàng
                                </span>

                            </label>


                            <!-- LOẠI -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Loại giảm giá
                                </span>

                                <select
                                    name="loai_giam_gia"
                                    required
                                    class="mt-1 w-full border rounded-lg px-3 py-2 bg-white"
                                >

                                    <option value="percent">
                                        Theo phần trăm (%)
                                    </option>

                                    <option value="shipping">
                                        Theo phí ship
                                    </option>

                                </select>

                                <span class="text-xs text-gray-400">
                                    Voucher giảm theo phần trăm
                                </span>

                            </label>


                            <!-- GIÁ TRỊ -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Giá trị giảm
                                </span>

                                <input
                                    name="gia_tri_giam"
                                    required
                                    type="number"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="Ví dụ: 10"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    Nhập 10 = giảm 10%
                                </span>

                            </label>


                            <!-- ĐƠN TỐI THIỂU -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Đơn tối thiểu (đ)
                                </span>

                                <input
                                    name="don_hang_toi_thieu"
                                    required
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    Giá trị đơn tối thiểu để dùng voucher
                                </span>

                            </label>


                            <!-- GIẢM TỐI ĐA -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Giảm tối đa (đ)
                                </span>

                                <input
                                    name="giam_toi_da"
                                    required
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    0 = không giới hạn
                                </span>

                            </label>


                            <!-- SỐ LƯỢT -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Số lượt sử dụng
                                </span>

                                <input
                                    name="so_luong_dung"
                                    required
                                    type="number"
                                    min="0"
                                    value="0"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    0 = không giới hạn
                                </span>

                            </label>


                            <!-- BẮT ĐẦU -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Bắt đầu từ
                                </span>

                                <input
                                    name="ngay_bat_dau"
                                    type="datetime-local"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    Thời điểm voucher bắt đầu có hiệu lực
                                </span>

                            </label>


                            <!-- KẾT THÚC -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Kết thúc vào
                                </span>

                                <input
                                    name="ngay_ket_thuc"
                                    type="datetime-local"
                                    class="mt-1 w-full border rounded-lg px-3 py-2"
                                >

                                <span class="text-xs text-gray-400">
                                    Để trống nếu không giới hạn
                                </span>

                            </label>


                            <!-- TRẠNG THÁI -->
                            <label class="text-sm text-gray-700">

                                <span class="font-medium">
                                    Trạng thái
                                </span>

                                <select
                                    name="trang_thai"
                                    required
                                    class="mt-1 w-full border rounded-lg px-3 py-2 bg-white"
                                >

                                    <option value="active">
                                        Đang hoạt động
                                    </option>

                                    <option value="inactive">
                                        Tạm ngưng
                                    </option>

                                </select>

                                <span class="text-xs text-gray-400">
                                    Trạng thái hoạt động của voucher
                                </span>

                            </label>


                            <!-- KÍCH HOẠT -->
                            <label class="flex items-center gap-2 px-3 py-2 mt-5">

                                <input
                                    type="checkbox"
                                    name="trang_thai_kich_hoat"
                                    value="1"
                                    checked
                                    class="accent-orange-600"
                                >

                                <div>

                                    <span class="text-sm text-gray-700">
                                        Đang kích hoạt
                                    </span>

                                    <p class="text-xs text-gray-400">
                                        Cho phép khách hàng sử dụng
                                    </p>

                                </div>

                            </label>

                        </div>


                        <button
                            class="mt-5 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-semibold"
                        >
                            <i class="fa-solid fa-plus mr-1"></i>
                            Thêm voucher
                        </button>

                    </form>


                    <!-- ========================= -->
                    <!-- DANH SÁCH VOUCHER -->
                    <!-- ========================= -->

                    <div class="space-y-5">

                        @forelse($vouchers as $voucher)

                            <form
                                action="{{ route('admin.vouchers.update', $voucher->id) }}"
                                method="POST"
                                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden"
                            >

                                @csrf

                                @method('PUT')


                                <!-- VOUCHER HEADER -->

                                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-11 h-11 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center"
                                        >
                                            <i class="fa-solid fa-ticket text-lg"></i>
                                        </div>

                                        <div>

                                            <h3 class="text-lg font-bold text-gray-900">
                                                {{ $voucher->ma_code }}
                                            </h3>

                                            <p class="text-xs text-gray-500">
                                                Mã giảm giá
                                            </p>

                                        </div>

                                    </div>


                                    <div class="flex items-center gap-2">

                                        @if($voucher->isExpired())

                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                <i class="fa-solid fa-clock mr-1"></i>
                                                Đã hết hạn
                                            </span>

                                        @elseif($voucher->trang_thai === 'active')

                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                <i class="fa-solid fa-circle-check mr-1"></i>
                                                Đang hoạt động
                                            </span>

                                        @else

                                            <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-semibold">
                                                <i class="fa-solid fa-pause mr-1"></i>
                                                Tạm ngưng
                                            </span>

                                        @endif


                                        @if($voucher->trang_thai_kich_hoat)

                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                                Đã kích hoạt
                                            </span>

                                        @else

                                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">
                                                Chưa kích hoạt
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <!-- VOUCHER BODY -->

                                <div class="p-6">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                                        <!-- MÃ VOUCHER -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Mã voucher
                                            </label>

                                            <input
                                                name="ma_code"
                                                required
                                                maxlength="50"
                                                value="{{ $voucher->ma_code }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2 uppercase font-semibold text-gray-800"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                Mã khách hàng nhập để sử dụng
                                            </p>

                                        </div>


                                        <!-- LOẠI -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Loại giảm giá
                                            </label>

                                            <select
                                                name="loai_giam_gia"
                                                required
                                                class="mt-1 w-full border rounded-lg px-3 py-2 bg-white"
                                            >

                                                <option
                                                    value="percent"
                                                    {{ $voucher->loai_giam_gia === 'percent' ? 'selected' : '' }}
                                                >
                                                    Theo phần trăm (%)
                                                </option>

                                                <option
                                                    value="shipping"
                                                    {{ $voucher->loai_giam_gia === 'shipping' ? 'selected' : '' }}
                                                >
                                                    Theo phí ship
                                                </option>

                                            </select>

                                            

                                            <p class="text-xs text-gray-400 mt-1">
                                                Hình thức giảm giá
                                            </p>

                                        </div>


                                        <!-- GIÁ TRỊ -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Giá trị giảm
                                            </label>

                                            <div class="relative">

                                                <input
                                                    name="gia_tri_giam"
                                                    required
                                                    type="number"
                                                    min="0"
                                                    max="{{ $voucher->loai_giam_gia === 'percent' ? 100 : '' }}"
                                                    step="0.01"
                                                    value="{{ $voucher->gia_tri_giam }}"
                                                    class="mt-1 w-full border rounded-lg px-3 py-2 pr-10 font-semibold"
                                                >

                                                <span class="absolute right-3 top-3 text-gray-400">
                                                    {{ $voucher->loai_giam_gia === 'shipping' ? 'đ' : '%' }}
                                                </span>

                                            </div>

                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $voucher->loai_giam_gia === 'shipping' ? 'Miễn phí hoặc giảm theo phí vận chuyển' : 'Phần trăm được giảm trên đơn hàng' }}
                                            </p>

                                        </div>


                                        <!-- ĐƠN TỐI THIỂU -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Đơn hàng tối thiểu
                                            </label>

                                            <input
                                                name="don_hang_toi_thieu"
                                                required
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                value="{{ $voucher->don_hang_toi_thieu }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                Giá trị đơn tối thiểu để áp dụng
                                            </p>

                                        </div>


                                        <!-- GIẢM TỐI ĐA -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Giảm tối đa
                                            </label>

                                            <input
                                                name="giam_toi_da"
                                                required
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                value="{{ $voucher->giam_toi_da }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                0 = không giới hạn số tiền giảm
                                            </p>

                                        </div>


                                        <!-- LƯỢT SỬ DỤNG -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Số lượt sử dụng
                                            </label>

                                            <input
                                                name="so_luong_dung"
                                                required
                                                type="number"
                                                min="0"
                                                value="{{ $voucher->so_luong_dung }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                0 = không giới hạn lượt sử dụng
                                            </p>

                                        </div>


                                        <!-- BẮT ĐẦU -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Thời gian bắt đầu
                                            </label>

                                            <input
                                                name="ngay_bat_dau"
                                                type="datetime-local"
                                                value="{{ optional($voucher->ngay_bat_dau)->format('Y-m-d\\TH:i') }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                Thời điểm voucher bắt đầu hoạt động
                                            </p>

                                        </div>


                                        <!-- KẾT THÚC -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Thời gian kết thúc
                                            </label>

                                            <input
                                                name="ngay_ket_thuc"
                                                type="datetime-local"
                                                value="{{ optional($voucher->ngay_ket_thuc)->format('Y-m-d\\TH:i') }}"
                                                class="mt-1 w-full border rounded-lg px-3 py-2"
                                            >

                                            <p class="text-xs text-gray-400 mt-1">
                                                Để trống nếu voucher không hết hạn
                                            </p>

                                        </div>


                                        <!-- TRẠNG THÁI -->

                                        <div>

                                            <label class="text-xs font-semibold text-gray-500 uppercase">
                                                Trạng thái
                                            </label>

                                            <select
                                                name="trang_thai"
                                                required
                                                class="mt-1 w-full border rounded-lg px-3 py-2 bg-white"
                                            >

                                                <option
                                                    value="active"
                                                    {{ $voucher->trang_thai === 'active' ? 'selected' : '' }}
                                                >
                                                    Đang hoạt động
                                                </option>

                                                <option
                                                    value="inactive"
                                                    {{ $voucher->trang_thai === 'inactive' ? 'selected' : '' }}
                                                >
                                                    Tạm ngưng
                                                </option>

                                            </select>

                                            <p class="text-xs text-gray-400 mt-1">
                                                Trạng thái hiện tại của voucher
                                            </p>

                                        </div>


                                    </div>


                                    <!-- KÍCH HOẠT -->

                                    <div class="mt-5 pt-5 border-t border-gray-100">

                                        <label class="flex items-center gap-3 cursor-pointer">

                                            <input
                                                type="checkbox"
                                                name="trang_thai_kich_hoat"
                                                value="1"
                                                {{ $voucher->trang_thai_kich_hoat ? 'checked' : '' }}
                                                class="w-4 h-4 accent-orange-600"
                                            >

                                            <div>

                                                <p class="text-sm font-medium text-gray-700">
                                                    Kích hoạt voucher
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    Khi được kích hoạt, khách hàng có thể sử dụng mã giảm giá này
                                                </p>

                                            </div>

                                        </label>

                                    </div>


                                    <!-- BUTTON -->

                                    <div class="flex justify-end gap-3 mt-6">

                                        <button
                                            type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold"
                                        >
                                            <i class="fa-solid fa-floppy-disk mr-1"></i>
                                            Lưu thay đổi
                                        </button>


                                        <button
                                            type="submit"
                                            formaction="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                            formmethod="POST"
                                            name="_method"
                                            value="DELETE"
                                            onclick="return confirm('Bạn có chắc muốn xóa voucher này?')"
                                            class="bg-red-50 hover:bg-red-100 text-red-600 px-6 py-2.5 rounded-lg font-semibold"
                                        >
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Xóa voucher
                                        </button>

                                    </div>

                                </div>

                            </form>

                        @empty

                            <div
                                class="bg-white rounded-xl border border-dashed border-gray-300 p-10 text-center"
                            >

                                <i class="fa-solid fa-ticket text-4xl text-gray-300 mb-3"></i>

                                <p class="text-gray-400">
                                    Chưa có voucher nào.
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    Hãy tạo voucher đầu tiên cho khách hàng.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </section>
                @endif


                <!-- ========================= -->
                <!-- DANH SÁCH ĐƠN HÀNG -->
                <!-- ========================= -->

                @if(($section ?? 'orders') === 'orders')
                <div id="orders" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-8">

                    <table class="w-full border-collapse text-left text-sm text-gray-600">

                        <thead
                            class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase text-xs"
                        >

                            <tr>

                                <th class="p-4 font-semibold">
                                    Mã đơn
                                </th>

                                <th class="p-4 font-semibold">
                                    Khách hàng
                                </th>

                                <th class="p-4 font-semibold">
                                    Tổng tiền
                                </th>

                                <th class="p-4 font-semibold">
                                    Trạng thái
                                </th>

                                <th class="p-4 font-semibold text-center">
                                    Thao tác
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-200">

                            @forelse($orders ?? [] as $order)

                                <tr class="hover:bg-gray-50/50">

                                    <td class="p-4 font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>

                                    <td class="p-4">
                                        {{ $order->ten_khach_hang ?? 'Khách lẻ' }}
                                    </td>

                                    <td class="p-4 font-semibold text-orange-600">
                                        {{ number_format($order->tong_tien ?? 0) }} đ
                                    </td>

                                    <td class="p-4">

                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">
                                            Chờ xử lý
                                        </span>

                                    </td>

                                    <td class="p-4 text-center">

                                        <a
                                            href="#"
                                            class="text-blue-600 hover:text-blue-800 font-medium"
                                        >
                                            Chi tiết
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="p-8 text-center text-gray-400 italic"
                                    >
                                        Chưa có đơn hàng nào trong hệ thống.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>
                @endif

            </div>

        </main>

    </div>

</body>
</html>