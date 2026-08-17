<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienTheSanPham extends Model
{
    protected $table = 'bien_the_san_pham';
    public $timestamps = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}