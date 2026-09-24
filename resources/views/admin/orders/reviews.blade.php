@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-800">
                <span class="inline-block h-8 w-2.5 rounded-full bg-yellow-400"></span>
                Đánh giá của khách hàng
            </h2>
            <p class="mt-1 text-sm text-gray-500">Theo dõi đánh giá được gửi từ các đơn hàng đã hoàn thành.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:border-orange-500 hover:text-orange-600">
            <i class="fa-solid fa-arrow-left mr-2"></i>Quản lý đơn hàng
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="rounded-xl border border-yellow-100 bg-yellow-50 p-5">
            <p class="text-sm font-medium text-yellow-700">Tổng số đánh giá</p>
            <p class="mt-2 text-3xl font-bold text-yellow-800">{{ number_format($reviewCount) }}</p>
        </div>
        <div class="rounded-xl border border-orange-100 bg-orange-50 p-5">
            <p class="text-sm font-medium text-orange-700">Điểm trung bình</p>
            <p class="mt-2 text-3xl font-bold text-orange-800"><i class="fa-solid fa-star mr-1 text-yellow-500"></i>{{ number_format($averageRating, 1) }}/5</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm text-gray-600">
                <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="p-4 font-semibold">Sản phẩm</th>
                        <th class="p-4 font-semibold">Khách hàng</th>
                        <th class="p-4 font-semibold">Đánh giá</th>
                        <th class="p-4 font-semibold">Nội dung</th>
                        <th class="p-4 font-semibold">Ngày gửi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if($review->sanPham)
                                        <img src="{{ $review->sanPham->image_url }}" alt="{{ $review->sanPham->ten_san_pham }}" class="h-12 w-12 rounded border border-gray-200 bg-gray-50 object-contain p-1">
                                        <span class="font-semibold text-gray-800">{{ $review->sanPham->ten_san_pham }}</span>
                                    @else
                                        <span class="text-gray-400">Sản phẩm không còn tồn tại</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">{{ $review->nguoiDung->ho_ten ?? $review->nguoiDung->name ?? $review->nguoiDung->username ?? 'Khách hàng' }}</td>
                            <td class="whitespace-nowrap p-4 text-yellow-500">
                                @for($star = 1; $star <= 5; $star++)
                                    <i class="fa-solid fa-star {{ $star <= $review->so_sao ? '' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="ml-1 text-xs text-gray-500">({{ $review->so_sao }}/5)</span>
                            </td>
                            <td class="max-w-sm p-4 text-gray-700">{{ $review->noi_dung ?: 'Không có nội dung' }}</td>
                            <td class="whitespace-nowrap p-4">{{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">Chưa có đánh giá nào từ khách hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
            <div class="border-t border-gray-200 p-4">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
