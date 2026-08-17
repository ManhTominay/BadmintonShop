<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'gio_hang';
    public $timestamps = false;

    protected $fillable = [
        'nguoi_dung_id', 'bien_the_id', 'so_luong', 
        'cuoc_kem_bien_the_id', 'so_kg_cang'
    ];
}