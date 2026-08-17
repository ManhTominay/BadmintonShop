<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Top Bar -->
    <div class="bg-slate-900 text-white text-xs py-1 text-center font-medium">
        Badminton Essential Equipment
    </div>

    <!-- Header Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <button class="text-gray-600 hover:text-orange-500"><i class="fa-solid fa-magnifying-glass text-lg"></i></button>

            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-500"></i>
                <div class="leading-none">
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-900 uppercase">BADMINTON</h1>
                    <p class="font-bold text-xs tracking-widest text-orange-500 uppercase">PRO SHOP</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-orange-500"><i class="fa-regular fa-user text-xl"></i></a>
                <a href="#" class="relative text-gray-600 hover:text-orange-500">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>

        <nav class="border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <ul class="flex items-center justify-center space-x-8 py-2 text-xs font-bold uppercase tracking-wider">
                    <li><a href="#" class="text-orange-500 border-b-2 border-orange-500 pb-1">HOME</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">RACKETS</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">SHOES</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">APPAREL</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">SHUTTLECOCKS</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">ACCESSORIES</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">STRINGING SERVICE</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition text-red-600">CLEARANCE</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Banner Hero -->
    <section class="bg-slate-900 text-white py-12 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 items-center">
            <div class="space-y-4">
                <h2 class="text-3xl font-extrabold uppercase leading-tight">
                    DOMINATE THE COURT.<br>NEW YONEX ASTROX SERIES ARRIVED.
                </h2>
                <a href="#" class="inline-block bg-orange-500 text-white font-bold px-6 py-2.5 rounded text-xs uppercase hover:bg-orange-600">SHOP RACKETS NOW</a>
            </div>
        </div>
    </section>

    <!-- Shop By Category -->
    <section class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-center font-extrabold text-lg uppercase mb-6">SHOP BY CATEGORY</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            <a href="#" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center">
                <i class="fa-solid fa-table-tennis-paddle-ball text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">RACKETS</span>
            </a>
            <a href="#" class="bg-orange-500 rounded-lg p-4 text-center text-white flex flex-col items-center">
                <i class="fa-solid fa-shoe-prints text-3xl text-white mb-2"></i>
                <span class="text-xs font-bold">SHOES</span>
            </a>
            <a href="#" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center">
                <i class="fa-solid fa-shuttlecock text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">SHUTTLECOCKS</span>
            </a>
            <a href="#" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center">
                <i class="fa-solid fa-suitcase-rolling text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">BAGS</span>
            </a>
            <a href="#" class="bg-slate-900 rounded-lg p-4 text-center text-white flex flex-col items-center">
                <i class="fa-solid fa-screwdriver-wrench text-3xl text-orange-400 mb-2"></i>
                <span class="text-xs font-bold">STRINGING</span>
            </a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="max-w-6xl mx-auto px-4 pb-12">
        <h2 class="text-center font-extrabold text-lg uppercase mb-6">FEATURED PRODUCTS</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

            @foreach($sanPhams as $sp)
            <div class="bg-white rounded p-4 border border-gray-100 flex flex-col justify-between hover:shadow-md transition relative">
                @if($sp->la_san_pham_moi)
                    <span class="absolute top-3 left-3 bg-orange-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">New</span>
                @endif
                <div>
                    <div class="h-36 bg-gray-50 rounded flex items-center justify-center mb-3">
                        <i class="fa-solid fa-table-tennis-paddle-ball text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-800">{{ $sp->ten_san_pham }}</h3>
                    <div class="flex text-yellow-400 text-[10px] my-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-900">{{ number_format($sp->gia_co_ban, 0, ',', '.') }} VNĐ</p>
                </div>
                
                <form action="{{ route('cart.add') }}" method="POST" class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                    @csrf
                    <input type="hidden" name="bien_the_id" value="{{ $sp->bienThes->first()->id ?? 1 }}">
                    <input type="hidden" name="so_luong" value="1">
                    <button type="submit" class="bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded hover:bg-orange-500 transition">Add to Cart</button>
                    <label class="text-[10px] text-gray-500 flex items-center"><input type="checkbox" class="mr-1"> Compare</label>
                </form>
            </div>
            @endforeach

            <!-- Racket Setup Custom Widget -->
            <div class="bg-white rounded p-4 border border-gray-200 shadow-sm flex flex-col justify-between">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-900 uppercase mb-3">GET YOUR PERFECT RACKET SETUP</h3>
                    
                    <div class="space-y-2 text-xs">
                        <select name="bien_the_id" class="w-full border rounded p-1.5 text-gray-600 text-[11px] bg-white" required>
                            <option value="">Chọn Vợt & Trọng lượng</option>
                            @foreach($sanPhams as $sp)
                                @foreach($sp->bienThes as $bt)
                                    <option value="{{ $bt->id }}">{{ $sp->ten_san_pham }} ({{ $bt->trong_luong_vot ?? '4U' }})</option>
                                @endforeach
                            @endforeach
                        </select>

                        <select name="cuoc_kem_bien_the_id" class="w-full border rounded p-1.5 text-gray-600 text-[11px] bg-white">
                            <option value="">Chọn Loại Cước Đan</option>
                            @foreach($danhSachCuoc as $cuoc)
                                <option value="{{ $cuoc->id }}">{{ $cuoc->sanPham->ten_san_pham ?? 'Cước Yonex' }}</option>
                            @endforeach
                        </select>

                        <select name="so_kg_cang" class="w-full border rounded p-1.5 text-gray-600 text-[11px] bg-white">
                            <option value="">Mức căng (Tension)</option>
                            <option value="10.5">10.5 kg (23 lbs)</option>
                            <option value="11.0">11.0 kg (24 lbs)</option>
                            <option value="11.5">11.5 kg (25 lbs)</option>
                            <option value="12.0">12.0 kg (26 lbs)</option>
                        </select>
                        <input type="hidden" name="so_luong" value="1">
                    </div>

                    <button type="submit" class="w-full mt-4 bg-slate-900 text-white text-xs font-bold py-2 rounded hover:bg-orange-500 transition">
                        Add to Cart
                    </button>
                </form>
            </div>

        </div>
    </section>

</body>
</html>