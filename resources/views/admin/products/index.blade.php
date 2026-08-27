<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Danh sách sản phẩm</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Tên sản phẩm</th>
                    <th class="border p-2">Giá cơ bản</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="border p-2 text-center">{{ $product->id }}</td>
                        <td class="border p-2">{{ $product->ten_san_pham }}</td>
                        <td class="border p-2">{{ number_format($product->gia_co_ban) }} đ</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-4 text-center text-gray-500">Chưa có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>