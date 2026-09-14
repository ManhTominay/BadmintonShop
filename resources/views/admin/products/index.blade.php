@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <span class="w-2.5 h-8 bg-orange-600 rounded-full inline-block"></span>
                Quản lý sản phẩm
            </h2>
            <p class="text-sm text-gray-500 mt-1">Danh sách toàn bộ sản phẩm cầu lông trong hệ thống</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm sản phẩm mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @php
        $categoryFilters = [
            'all' => 'Tất cả sản phẩm',
            'vot' => 'Vợt',
            'giay' => 'Giày',
            'quan-ao' => 'Quần áo',
            'cau' => 'Cầu',
            'phu-kien' => 'Phụ kiện',
        ];
    @endphp

    <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
        <div class="mb-4 flex flex-wrap gap-2">
            @foreach($categoryFilters as $filterKey => $filterLabel)
                <a href="{{ route('admin.products.index', ['category' => $filterKey, 'search' => $search]) }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors {{ $category === $filterKey ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    {{ $filterLabel }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
            <input type="hidden" name="category" value="{{ $category }}">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="search" name="search" value="{{ $search }}" placeholder="Tìm kiếm theo tên sản phẩm..." class="w-full rounded-lg border border-gray-200 py-2.5 pl-11 pr-4 text-sm text-gray-700 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
            </div>
            <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                <i class="fa-solid fa-magnifying-glass mr-2"></i>Tìm kiếm
            </button>
            @if($search !== '')
                <a href="{{ route('admin.products.index', ['category' => $category]) }}" class="rounded-lg border border-gray-200 px-5 py-2.5 text-center text-sm font-semibold text-gray-600 transition hover:border-orange-500 hover:text-orange-600">
                    Xóa tìm kiếm
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full border-collapse text-left text-sm text-gray-600">
            <thead class="bg-gray-50/75 border-b border-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4 font-bold text-center w-16">ID</th>
                    <th class="p-4 font-bold">Tên sản phẩm</th>
                    <th class="p-4 font-bold">Danh mục</th>
                    <th class="p-4 font-bold">Giá cơ bản</th>
                    <th class="p-4 font-bold text-center">Số lượng</th>
                    <th class="p-4 font-bold text-center w-36">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                    <tr class="hover:bg-orange-50/30 transition-colors">
                        <td class="p-4 text-center font-semibold text-gray-500">#{{ $product->id }}</td>
                        <td class="p-4 font-semibold text-gray-900 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                {{ substr($product->ten_san_pham, 0, 2) }}
                            </div>
                            <span>{{ $product->ten_san_pham }}</span>
                        </td>
                        <td class="p-4">
                            @switch((int) $product->danh_muc_id)
                                @case(1) Vợt @break
                                @case(2) Giày @break
                                @case(3) Cầu @break
                                @case(4) Quần áo @break
                                @case(5) Phụ kiện @break
                                @default Chưa phân loại
                            @endswitch
                        </td>
                        <td class="p-4 font-bold text-orange-600">{{ number_format($product->gia_co_ban) }} đ</td>
                        <td class="p-4 text-center">
                            @if(($product->so_luong ?? 0) > 0)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Còn hàng ({{ $product->so_luong }})
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                    Hết hàng
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium text-xs transition-colors">
                                Sửa
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium text-xs transition-colors">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-400 italic">Không tìm thấy sản phẩm phù hợp.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection