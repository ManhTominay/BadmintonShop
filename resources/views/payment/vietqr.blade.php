<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán VietQR - BADMINTON PRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 px-4 py-10 text-slate-800">
    @php
        $qrInfo = urlencode($order->ma_don_hang);
        $qrAccountName = urlencode(config('services.sepay.account_name', ''));
        $qrUrl = 'https://img.vietqr.io/image/' . config('services.sepay.bank_code') . '-' . config('services.sepay.account_number') . '-compact2.png?amount=' . (int) $order->tong_thanh_toan . '&addInfo=' . $qrInfo . '&accountName=' . $qrAccountName;
        $expiresAt = $order->qr_expires_at ? $order->qr_expires_at->timestamp * 1000 : 0;
        $qrConfigured = filled(config('services.sepay.bank_code')) && filled(config('services.sepay.account_number')) && filled(config('services.sepay.account_name'));
    @endphp

    <main class="mx-auto max-w-lg rounded-2xl bg-white p-6 text-center shadow-sm">
        <a href="{{ route('account.orders') }}" class="mb-5 inline-block text-sm font-semibold text-orange-600">&larr; Xem đơn hàng</a>
        <h1 class="text-2xl font-bold">Quét mã VietQR để thanh toán</h1>
        <p class="mt-2 text-sm text-slate-500">Đơn hàng <strong>{{ $order->ma_don_hang }}</strong></p>

        @if ($order->trang_thai_thanh_toan === 'da_thanh_toan')
            <div class="mt-6 rounded-lg bg-emerald-50 p-4 font-semibold text-emerald-700">Đã thanh toán thành công.</div>
        @elseif (!$order->qr_expires_at || $order->qr_expires_at->isPast())
            <div class="mt-6 rounded-lg bg-amber-50 p-4 text-amber-700">Mã QR đã hết hiệu lực. Đơn hàng vẫn đang ở trạng thái chờ thanh toán.</div>
        @elseif (!$qrConfigured)
            <div class="mt-6 rounded-lg bg-red-50 p-4 text-left text-sm text-red-700">
                Chưa cấu hình tài khoản VietQR. Hãy điền `SEPAY_BANK_CODE`, `SEPAY_ACCOUNT_NUMBER` và `SEPAY_ACCOUNT_NAME` trong file `.env`, sau đó chạy `php artisan config:clear` rồi tạo lại đơn hàng.
            </div>
        @else
            <img src="{{ $qrUrl }}" alt="Mã QR thanh toán VietQR" class="mx-auto mt-5 h-72 w-72 rounded-lg border bg-white p-2">
            <p class="mt-4 text-sm text-slate-600">Số tiền cần trả</p>
            <p class="text-2xl font-bold text-orange-600">{{ number_format($order->tong_thanh_toan, 0, ',', '.') }} ₫</p>
            <p class="mt-3 text-sm text-slate-600">Nội dung chuyển khoản: <strong>{{ $order->ma_don_hang }}</strong></p>
            <p id="countdown" class="mt-4 font-bold text-red-600"></p>
            <p class="mt-2 text-xs text-slate-500">Trang sẽ tự kiểm tra trạng thái thanh toán.</p>
        @endif
    </main>

    @if ($order->trang_thai_thanh_toan !== 'da_thanh_toan' && $order->qr_expires_at && $order->qr_expires_at->isFuture())
        <script>
            const expiresAt = {{ $expiresAt }};
            const countdown = document.getElementById('countdown');
            const tick = () => {
                const remaining = Math.max(0, expiresAt - Date.now());
                const seconds = Math.floor(remaining / 1000);
                countdown.textContent = `Mã QR còn hiệu lực ${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, '0')}`;
                if (remaining <= 0) {
                    window.location.reload();
                    return;
                }
                setTimeout(tick, 1000);
            };
            tick();
            setInterval(() => window.location.reload(), 5000);
        </script>
    @endif
</body>
</html>