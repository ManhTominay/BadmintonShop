<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập địa chỉ giao hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-sm max-w-lg w-full border border-gray-100">
        <h2 class="text-xl font-bold text-slate-900 mb-2 uppercase">Thông tin giao hàng</h2>
        <p class="text-xs text-gray-500 mb-6">Vui lòng điền địa chỉ nhận hàng cho lần mua đầu tiên của bạn.</p>

        <form action="{{ route('checkout.address.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-gray-700 mb-1">Họ tên người nhận</label>
                <input type="text" name="ten_nguoi_nhan" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block font-bold text-gray-700 mb-1">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tỉnh / Thành phố</label>
                    <input type="text" name="tinh_thanh" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Phường / Xã</label>
                    <input type="text" name="phuong_xa" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
                </div>
            </div>
            <div>
                <label class="block font-bold text-gray-700 mb-1">Địa chỉ chi tiết (Số nhà, tên đường...)</label>
                <input type="text" name="dia_chi_chi_tiet" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
            </div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md uppercase">
                Lưu và tiếp tục thanh toán
            </button>
        </form>
    </div>
</body>
</html>