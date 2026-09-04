<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienTheSanPham extends Model
{
    protected $table = 'bien_the_san_pham';
    public $timestamps = false;

    protected $fillable = [
        'san_pham_id',
        'size',
        'mau_sac',
        'so_luong_ton',
        'so_luong_ton_kho',
        'ma_sku',
        'gia',
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}