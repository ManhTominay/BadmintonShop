<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Bắt buộc chỉ định tên bảng trong CSDL
     */
    protected $table = 'nguoi_dung';

    /**
     * Tắt timestamps (created_at, updated_at) nếu bảng nguoi_dung không dùng 2 cột này
     */
    public $timestamps = false;

    /**
     * Các trường cho phép chèn dữ liệu hàng loạt
     */
    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'mat_khau_hash',
        'vai_tro',
    ];

    /**
     * Bật ẩn trường nhạy cảm khi serialize
     */
    protected $hidden = [
        'mat_khau_hash',
        'remember_token',
    ];

    /**
     * Chỉ định cho Laravel Auth biết cột mật khẩu mã hóa tên là mat_khau_hash
     */
    public function getAuthPassword()
    {
        return $this->mat_khau_hash;
    }
}