<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Cầu Lông</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-slate-800">DANH SÁCH CẦU THI ĐẤU</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($danhSachCau as $cau)
            <div class="bg-white p-4 rounded shadow border border-gray-100">
                <img src="{{ asset('images/' . $cau->anh_dai_dien) }}" alt="{{ $cau->ten_san_pham }}" class="h-40 w-full object-contain mb-3">
                <h3 class="font-bold text-sm text-gray-800">{{ $cau->ten_san_pham }}</h3>
                <p class="text-orange-500 font-bold text-sm mt-2">{{ number_format($cau->gia_co_ban, 0, ',', '.') }} VNĐ</p>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>