@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-800">
                <span class="inline-block h-8 w-2.5 rounded-full bg-red-500"></span>
                Lý do hủy đơn
            </h2>
            <p class="mt-1 text-sm text-gray-500">Theo dõi số lượng và nguyên nhân khách hàng hủy đơn.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:border-orange-500 hover:text-orange-600">
            <i class="fa-solid fa-arrow-left mr-2"></i>Quản lý đơn hàng
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-red-100 bg-red-50 p-5">
            <p class="text-sm font-medium text-red-700">Tổng đơn đã hủy</p>
            <p class="mt-2 text-3xl font-bold text-red-800">{{ number_format($cancelledCount) }}</p>
        </div>
        <div class="rounded-xl border border-orange-100 bg-orange-50 p-5">
            <p class="text-sm font-medium text-orange-700">Số nhóm lý do</p>
            <p class="mt-2 text-3xl font-bold text-orange-800">{{ $reasonSummary->count() }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <p class="text-sm font-medium text-gray-500">Lý do phổ biến nhất</p>
            <p class="mt-2 line-clamp-2 text-sm font-bold text-gray-800">{{ $reasonSummary->first()->ly_do_huy ?? 'Chưa có dữ liệu' }}</p>
        </div>
    </div>

    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-bold text-gray-800">Thống kê theo lý do</h3>
        @forelse($reasonSummary as $reason)
            <div class="mb-4 last:mb-0">
                <div class="mb-1 flex items-start justify-between gap-4 text-sm">
                    <span class="text-gray-700">{{ $reason->ly_do_huy }}</span>
                    <span class="whitespace-nowrap font-bold text-red-600">{{ number_format($reason->total) }} đơn</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                    <div class="h-full rounded-full bg-orange-500" style="width: {{ $cancelledCount > 0 ? ($reason->total / $cancelledCount) * 100 : 0 }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Chưa có đơn hàng nào bị hủy.</p>
        @endforelse
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">Danh sách đơn đã hủy</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-gray-600">
                <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="p-4 font-semibold">Mã đơn</th>
                        <th class="p-4 font-semibold">Khách hàng</th>
                        <th class="p-4 font-semibold">Tổng tiền</th>
                        <th class="p-4 font-semibold">Lý do hủy</th>
                        <th class="p-4 font-semibold">Ngày tạo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($cancelledOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-900">#{{ $order->ma_don_hang ?? $order->id }}</td>
                            <td class="p-4">{{ $order->ten_nguoi_nhan ?? 'Khách lẻ' }}</td>
                            <td class="p-4 font-semibold text-orange-600">{{ number_format($order->tong_thanh_toan ?? $order->tong_tien_hang ?? 0, 0, ',', '.') }} đ</td>
                            <td class="max-w-md p-4 text-gray-700">{{ $order->ly_do_huy ?? 'Không có lý do' }}</td>
                            <td class="p-4">{{ $order->ngay_tao ? date('d/m/Y H:i', strtotime($order->ngay_tao)) : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">Chưa có đơn hàng nào bị hủy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($cancelledOrders->hasPages())
            <div class="border-t border-gray-200 p-4">
                {{ $cancelledOrders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
