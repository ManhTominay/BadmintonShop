@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Thêm tài khoản mới</h2>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Họ và tên -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                <input type="text" name="ho_ten" value="{{ old('ho_ten') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                <input type="password" name="mat_khau" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Vai trò -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
                <select name="vai_tro" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <option value="khach_hang" {{ old('vai_tro') == 'khach_hang' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ old('vai_tro') == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-semibold hover:bg-orange-700">Thêm tài khoản</button>
            </div>
        </form>
    </div>
</div>
@endsection