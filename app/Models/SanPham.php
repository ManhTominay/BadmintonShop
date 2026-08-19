<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ThongSoVot;
use App\Models\BienTheSanPham;

class SanPham extends Model
{
    protected $table = 'san_pham';
    public $timestamps = false;

    protected $fillable = [
        'ten_san_pham', 
        'slug', 
        'danh_muc_id', 
        'thuong_hieu_id', 
        'mo_ta', 
        'gia_co_ban', 
        'anh_dai_dien', 
        'la_san_pham_noi_bat', 
        'la_san_pham_moi', 
        'trang_thai_kinh_doanh'
    ];

    /**
     * Mối quan hệ 1-N với biến thể sản phẩm (Kích thước, màu sắc...)
     */
    public function bienThes()
    {
        return $this->hasMany(BienTheSanPham::class, 'san_pham_id');
    }

    /**
     * Mối quan hệ 1-1 với thông số kỹ thuật của vợt
     */
    public function thongSoVot()
    {
        return $this->hasOne(ThongSoVot::class, 'san_pham_id');
    }
}