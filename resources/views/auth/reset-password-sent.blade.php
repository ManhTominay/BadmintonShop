<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên kết gửi thành công - BADMINTON PRO SHOP</title>
    <base href="{{ asset('/') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-8">
                <!-- Success Icon -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <i class="fa-solid fa-check text-3xl text-green-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Liên kết đã gửi!</h1>
                    <p class="text-gray-600 text-sm">Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn</p>
                </div>

                <!-- Email Display -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-center">
                    <p class="text-sm text-gray-600 mb-1">Email</p>
                    <p class="text-lg font-semibold text-blue-600">{{ session('email') ?? 'Email của bạn' }}</p>
                </div>

                <!-- Reset URL (for development only) -->
                @if(session('reset_url'))
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-xs text-gray-600 mb-2 font-semibold">Liên kết đặt lại (Nhân bản để sử dụng):</p>
                        <div class="bg-white border border-gray-300 rounded p-2 mb-2 break-all text-xs">
                            <code>{{ session('reset_url') }}</code>
                        </div>
                        <p class="text-xs text-gray-500">Lưu ý: Đây chỉ cho mục đích phát triển. Trong production, hãy gửi email thật.</p>
                    </div>
                @endif

                <!-- Instructions -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2 text-sm">Các bước tiếp theo:</h3>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-gray-600">
                        <li>Kiểm tra email của bạn</li>
                        <li>Nhấp vào liên kết "Đặt lại mật khẩu"</li>
                        <li>Nhập mật khẩu mới</li>
                        <li>Đăng nhập với mật khẩu mới</li>
                    </ol>
                </div>

                <!-- Buttons -->
                <div class="space-y-3">
                    <a
                        href="{{ route('login') }}"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Quay lại đăng nhập
                    </a>
                    <a
                        href="{{ route('home') }}"
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-home"></i>
                        Trang chủ
                    </a>
                </div>

                <!-- Help Text -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                    <p class="text-sm text-gray-600">
                        <i class="fa-solid fa-info-circle text-blue-600 mr-2"></i>
                        Không tìm thấy email? Kiểm tra thư mục Spam
                    </p>
                </div>
            </div>

            <!-- Footer Text -->
            <p class="text-center text-gray-500 text-xs mt-6">
                © 2024 BADMINTON PRO SHOP. Bảo vệ quyền riêng tư của bạn.
            </p>
        </div>
    </div>

</body>
</html>
