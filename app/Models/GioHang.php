<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'gio_hang';
    public $timestamps = false;

    protected $fillable = [
        'nguoi_dung_id', 'bien_the_id', 'so_luong', 'size',
        'cuoc_kem_bien_the_id', 'so_kg_cang'
    ];

    public function variant()
    {
        return $this->belongsTo(BienTheSanPham::class, 'bien_the_id');
    }

    public static function cleanupInvalidItemsForUser($userId)
    {
        $invalidIds = self::where('nguoi_dung_id', $userId)
            ->with(['variant', 'variant.sanPham'])
            ->get()
            ->filter(function ($item) {
                return !$item->variant || !$item->variant->sanPham;
            })
            ->pluck('id');

        if ($invalidIds->isNotEmpty()) {
            self::whereIn('id', $invalidIds)->delete();
        }
    }

    public static function validCartCount($userId)
    {
        self::cleanupInvalidItemsForUser($userId);

        return (int) self::where('nguoi_dung_id', $userId)
            ->sum('so_luong');
    }
}