<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Danh sách đơn hàng</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Mã đơn hàng</th>
                    <th class="border p-2">Tên người nhận</th>
                    <th class="border p-2">Tổng thanh toán</th>
                    <th class="border p-2">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="border p-2 text-center">{{ $order->id }}</td>
                        <td class="border p-2 text-center">{{ $order->ma_don_hang }}</td>
                        <td class="border p-2">{{ $order->ten_nguoi_nhan }}</td>
                        <td class="border p-2 text-right">{{ number_format($order->tong_thanh_toan ?? 0) }} đ</td>
                        <td class="border p-2 text-center">{{ $order->trang_thai_don_hang }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border p-4 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</body>
</html>