<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;

    protected $table = 'ma_giam_gia';

    public $timestamps = false;

    protected $fillable = [
        'ma_code',
        'loai_giam_gia',
        'gia_tri_giam',
        'don_hang_toi_thieu',
        'giam_toi_da',
        'so_luong_dung',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'trang_thai_kich_hoat',
    ];

    protected $casts = [
        'gia_tri_giam' => 'float',
        'don_hang_toi_thieu' => 'float',
        'giam_toi_da' => 'float',
        'ngay_bat_dau' => 'datetime',
        'ngay_ket_thuc' => 'datetime',
        'trang_thai_kich_hoat' => 'boolean',
    ];
}
