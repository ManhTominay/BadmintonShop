<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // Trỏ đúng vào tên bảng hiện có trong database của bạn
    protected $table = 'dia_chi_nguoi_dung';

    protected $fillable = [
        'nguoi_dung_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'tinh_thanh',
        'phuong_xa',
        'dia_chi_chi_tiet'
    ];
}