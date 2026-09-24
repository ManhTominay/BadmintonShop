<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->vai_tro !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang quản trị!');
        }

        $donHangQuery = DB::table('don_hang');

        $tongSoNguoiDung = DB::table('nguoi_dung')->count();
        $tongSoSanPham = DB::table('san_pham')->count();
        $tongDonHang = $donHangQuery->count();

        $revenueEligibleStatuses = ['da_thanh_toan', 'DA_THANH_TOAN', 'hoan_thanh', 'dang_giao', 'cho_giao_hang', 'van_chuyen'];
        $revenueEligibleWhere = function ($query) use ($revenueEligibleStatuses) {
            $query->whereIn('trang_thai_thanh_toan', $revenueEligibleStatuses)
                  ->orWhereIn('trang_thai_don_hang', $revenueEligibleStatuses);
        };

        $tongDoanhThu = (float) (clone $donHangQuery)
            ->where(function ($query) use ($revenueEligibleWhere) {
                $revenueEligibleWhere($query);
            })
            ->sum('tong_thanh_toan');

        $donHangDaThanhToan = (clone $donHangQuery)
            ->where(function ($query) use ($revenueEligibleWhere) {
                $revenueEligibleWhere($query);
            })
            ->count();

        $donHangChoXuLy = (clone $donHangQuery)->where('trang_thai_don_hang', 'cho_xu_ly')->count();
        $donHangDangGiao = (clone $donHangQuery)->where('trang_thai_don_hang', 'dang_giao')->count();
        $donHangHoanThanh = (clone $donHangQuery)->where('trang_thai_don_hang', 'hoan_thanh')->count();
        $donHangDaHuy = (clone $donHangQuery)->where('trang_thai_don_hang', 'da_huy')->count();

        $doanhThuHomNay = (float) (clone $donHangQuery)
            ->where(function ($query) use ($revenueEligibleWhere) {
                $revenueEligibleWhere($query);
            })
            ->whereDate('ngay_tao', today())
            ->sum('tong_thanh_toan');

        $doanhThu7Ngay = (float) (clone $donHangQuery)
            ->where(function ($query) use ($revenueEligibleWhere) {
                $revenueEligibleWhere($query);
            })
            ->where('ngay_tao', '>=', now()->subDays(6)->startOfDay())
            ->sum('tong_thanh_toan');

        $doanhThuThangNay = (float) (clone $donHangQuery)
            ->where(function ($query) use ($revenueEligibleWhere) {
                $revenueEligibleWhere($query);
            })
            ->whereMonth('ngay_tao', now()->month)
            ->whereYear('ngay_tao', now()->year)
            ->sum('tong_thanh_toan');

        $statusCounts = (clone $donHangQuery)
            ->select('trang_thai_don_hang', DB::raw('COUNT(*) as total'))
            ->groupBy('trang_thai_don_hang')
            ->get();

        $paymentCounts = (clone $donHangQuery)
            ->select('phuong_thuc_thanh_toan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('phuong_thuc_thanh_toan')
            ->groupBy('phuong_thuc_thanh_toan')
            ->get();

        $bestProducts = DB::table('chi_tiet_don_hang as ctdh')
            ->join('san_pham as sp', 'sp.id', '=', 'ctdh.san_pham_id')
            ->select('sp.id', 'sp.ten_san_pham', DB::raw('SUM(ctdh.so_luong) as so_luong_ban'), DB::raw('SUM(ctdh.thanh_tien) as doanh_thu'))
            ->groupBy('sp.id', 'sp.ten_san_pham')
            ->orderByDesc('so_luong_ban')
            ->limit(5)
            ->get();

        $revenueByDay = (clone $donHangQuery)
            ->select(
                DB::raw('DATE(ngay_tao) as ngay'),
                DB::raw('SUM(CASE WHEN (trang_thai_thanh_toan IN ("da_thanh_toan", "DA_THANH_TOAN") OR trang_thai_don_hang IN ("hoan_thanh", "dang_giao", "cho_giao_hang", "van_chuyen")) THEN tong_thanh_toan ELSE 0 END) as doanh_thu')
            )
            ->whereNotNull('ngay_tao')
            ->where('ngay_tao', '>=', now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(ngay_tao)'))
            ->orderBy('ngay', 'asc')
            ->get();

        $recentOrders = DB::table('don_hang as dh')
            ->leftJoin('nguoi_dung as nd', 'nd.id', '=', 'dh.nguoi_dung_id')
            ->select('dh.*', 'nd.ho_ten as ten_nguoi_mua')
            ->orderByDesc('dh.ngay_tao')
            ->limit(8)
            ->get();

        $statusLabels = [
            'cho_xu_ly' => 'Chờ xử lý',
            'dang_giao' => 'Đang giao',
            'cho_giao_hang' => 'Chờ giao hàng',
            'hoan_thanh' => 'Hoàn thành',
            'da_huy' => 'Đã hủy',
            'tra_hang' => 'Trả hàng',
            'hoan_tien' => 'Hoàn tiền',
        ];

        $paymentLabels = [
            'VietQR' => 'VietQR',
            'CashOnDelivery' => 'Thanh toán khi nhận hàng',
        ];

        return view('admin.dashboard', compact(
            'tongSoNguoiDung',
            'tongSoSanPham',
            'tongDonHang',
            'tongDoanhThu',
            'donHangDaThanhToan',
            'donHangChoXuLy',
            'donHangDangGiao',
            'donHangHoanThanh',
            'donHangDaHuy',
            'doanhThuHomNay',
            'doanhThu7Ngay',
            'doanhThuThangNay',
            'statusCounts',
            'paymentCounts',
            'bestProducts',
            'revenueByDay',
            'recentOrders',
            'statusLabels',
            'paymentLabels'
        ));
    }
}