<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected const DEFAULT_IMAGE = 'yonex_doura10.webp';

    protected $table = 'san_pham';
    public $timestamps = false;

    protected $fillable = [
        'ten_san_pham', 
        'slug', 
        'danh_muc_id', 
        'thuong_hieu_id', 
        'mo_ta', 
        'gia_co_ban', 
        'so_luong',
        'anh_dai_dien', 
        'la_san_pham_noi_bat', 
        'la_san_pham_moi', 
        'trang_thai_kinh_doanh'
    ];

    public static function resolveImageName(?string $imageName = null): string
    {
        $candidate = trim((string) ($imageName ?? ''));
        $candidate = preg_replace('#^/?(public|storage)/#i', '', $candidate);
        $candidate = preg_replace('#^images/?#i', '', $candidate);
        $candidate = ltrim($candidate, '/');

        if ($candidate === '') {
            return self::DEFAULT_IMAGE;
        }

        if (file_exists(public_path('images/' . $candidate))) {
            return $candidate;
        }

        $basename = basename($candidate);
        if ($basename !== '' && file_exists(public_path('images/' . $basename))) {
            return $basename;
        }

        return self::DEFAULT_IMAGE;
    }

    public function imageUrl(): string
    {
        return asset('images/' . self::resolveImageName($this->anh_dai_dien));
    }

    public function getImageUrlAttribute(): string
    {
        return $this->imageUrl();
    }

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