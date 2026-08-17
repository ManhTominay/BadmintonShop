<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongSoVot extends Model
{
    protected $table = 'thong_so_vot';
    protected $primaryKey = 'san_pham_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'san_pham_id', 
        'do_cung_than', 
        'diem_can_bang', 
        'trong_luong_chuandieu', 
        'muc_cang_toi_da_kg', 
        'chat_lieu_khung'
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}