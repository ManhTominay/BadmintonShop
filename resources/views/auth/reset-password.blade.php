<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - BADMINTON PRO SHOP</title>
    <base href="{{ asset('/') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-8">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}" class="inline-block">
                        <span class="text-3xl font-extrabold tracking-wider text-slate-900">BADMINTON</span>
                        <span class="block text-sm font-bold tracking-widest text-orange-500 uppercase">PRO SHOP</span>
                    </a>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Đặt lại mật khẩu</h1>
                    <p class="text-gray-600 text-sm">Nhập mã OTP đã được gửi đến Gmail của bạn.</p>
                </div>

                <!-- Thông báo thành công -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="list-disc list-inside text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form nhập OTP và mật khẩu mới -->
                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf <!-- Bảo mật chống lỗi 419 -->

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Địa chỉ Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror"
                            placeholder="Nhập email đã đăng ký của bạn"
                            required
                            autofocus
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="otp" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mã OTP <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            value="{{ old('otp') }}"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            maxlength="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('otp') border-red-500 @enderror"
                            placeholder="Nhập 6 chữ số"
                            required
                        />
                        @error('otp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mật khẩu mới <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" minlength="6" required />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" minlength="6" required />
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-paper-plane"></i>
                        Đổi mật khẩu
                    </button>
                </form>

                <!-- Divider -->
                <div class="flex items-center gap-3 my-6">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <span class="text-gray-500 text-sm">hoặc</span>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>

                <!-- Links -->
                <div class="space-y-3 text-center text-sm">
                    <p>
                        Nhớ lại mật khẩu?
                        <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                            Đăng nhập
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Text -->
            <p class="text-center text-gray-500 text-xs mt-6">
                © 2026 BADMINTON PRO SHOP. Bảo vệ quyền riêng tư của bạn.
            </p>
        </div>
    </div>

</body>
</html>