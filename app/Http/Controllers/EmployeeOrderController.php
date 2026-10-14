<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class EmployeeOrderController extends Controller
{
    public function index(Request $request)
    {
        $statusOptions = [
            'cho_xu_ly' => 'Chờ xác nhận',
            'dang_giao' => 'Đang giao',
            'cho_giao_hang' => 'Chờ giao hàng',
            'hoan_thanh' => 'Hoàn thành',
            'da_huy' => 'Đã hủy',
            'hoan_tien' => 'Hoàn tiền',
        ];
        $selectedStatus = $request->query('status');
        if (!array_key_exists($selectedStatus, $statusOptions)) {
            $selectedStatus = null;
        }

        $ordersQuery = DonHang::query();
        if ($selectedStatus === 'hoan_tien') {
            $ordersQuery->whereIn('trang_thai_don_hang', ['tra_hang', 'hoan_tien']);
        } elseif ($selectedStatus) {
            $ordersQuery->where('trang_thai_don_hang', $selectedStatus);
        }

        $orders = $ordersQuery->orderByDesc('id')->paginate(10)->appends($request->query());
        $statusCounts = DonHang::selectRaw('trang_thai_don_hang, COUNT(*) as total')
            ->groupBy('trang_thai_don_hang')
            ->pluck('total', 'trang_thai_don_hang');
        $statusCounts->put('hoan_tien', ($statusCounts['tra_hang'] ?? 0) + ($statusCounts['hoan_tien'] ?? 0));

        return view('employee.orders.index', compact('orders', 'statusOptions', 'selectedStatus', 'statusCounts'));
    }

    public function support()
    {
        $unreadUserIds = ChatMessage::where('sender_role', 'khach_hang')
            ->whereNull('read_at')
            ->pluck('nguoi_dung_id')
            ->unique()
            ->all();

        $conversations = ChatMessage::with('user')
            ->orderBy('id')
            ->get()
            ->groupBy('nguoi_dung_id');

        $unreadLookup = array_fill_keys(array_map('intval', $unreadUserIds), true);
        $conversations = $conversations->sortByDesc(function ($messages, $userId) use ($unreadLookup) {
            $unreadPriority = ($unreadLookup[(int) $userId] ?? false) ? 1000000000000 : 0;

            return $unreadPriority + (int) $messages->last()->id;
        });

        ChatMessage::where('sender_role', 'khach_hang')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('employee.support.index', compact('conversations', 'unreadUserIds'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:cho_xu_ly,dang_giao,cho_giao_hang,da_huy,tra_hang,hoan_tien',
        ]);

        DonHang::findOrFail($id)->update([
            'trang_thai_don_hang' => $request->trang_thai,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}