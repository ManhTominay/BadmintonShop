@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Thêm sản phẩm mới</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tên sản phẩm -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" value="{{ old('ten_san_pham') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Giá cơ bản -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá cơ bản</label>
                <input type="number" name="gia_co_ban" value="{{ old('gia_co_ban') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Số lượng -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng</label>
                <input type="number" name="so_luong" value="{{ old('so_luong', 1) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Ảnh đại diện -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
                <input type="file" name="anh_dai_dien" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-semibold hover:bg-orange-700">Thêm sản phẩm</button>
            </div>
        </form>
    </div>
</div>
@endsection