<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang'; // Khớp với tên bảng trong database

    // Nếu bảng không có cột updated_at, chỉ dùng ngay_tao làm created_at
    public $timestamps = false; 
    // Hoặc nếu bạn muốn Laravel tự động quản lý ngay_tao thay cho created_at:
    // const CREATED_AT = 'ngay_tao';
    // const UPDATED_AT = null;

    protected $fillable = [
        'ma_don_hang',
        'nguoi_dung_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'dia_chi_giao_hang',
        'tong_tien_hang',
        'phi_van_chuyen',
        'so_tien_giam',
        'tong_thanh_toan',
        'phuong_thuc_thanh_toan',
        'trang_thai_thanh_toan',
        'trang_thai_don_hang',
        'ly_do_huy',
        'ma_van_don',
        'ma_giam_gia_id',
        'sepay_transaction_id',
        'thoi_diem_thanh_toan',
        'qr_expires_at',
        'ngay_tao',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
        'thoi_diem_thanh_toan' => 'datetime',
    ];

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}