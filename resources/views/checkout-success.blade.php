<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - BADMINTON PRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gray-50 px-4 py-10 text-slate-800">
    <main class="mx-auto max-w-xl rounded-2xl bg-white p-8 text-center shadow-sm">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl text-green-600">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="mt-5 text-2xl font-bold">Đặt hàng thành công</h1>
        <p class="mt-2 text-sm text-gray-500">Cảm ơn bạn đã mua hàng tại BADMINTON PRO.</p>

        <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 p-4 text-left text-sm">
            <div class="flex justify-between gap-4">
                <span class="text-gray-500">Mã đơn hàng</span>
                <strong>{{ $order->ma_don_hang ?? '#' . $order->id }}</strong>
            </div>
            <div class="mt-3 flex justify-between gap-4">
                <span class="text-gray-500">Tổng thanh toán</span>
                <strong class="text-orange-600">{{ number_format($order->tong_thanh_toan, 0, ',', '.') }} ₫</strong>
            </div>
            <div class="mt-3 flex justify-between gap-4">
                <span class="text-gray-500">Thanh toán</span>
                <strong>{{ $order->phuong_thuc_thanh_toan === 'CashOnDelivery' ? 'Thanh toán khi nhận hàng' : $order->phuong_thuc_thanh_toan }}</strong>
            </div>
        </div>

        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('account.orders') }}" class="rounded-lg bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                <i class="fa-solid fa-box-open mr-1"></i>Xem đơn hàng
            </a>
            <a href="{{ route('home') }}" class="rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:border-orange-500 hover:text-orange-600">
                Tiếp tục mua sắm
            </a>
        </div>
    </main>
</body>
</html>
