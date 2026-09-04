<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'dia_chi_nguoi_dung';

    protected $fillable = [
        'nguoi_dung_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'tinh_thanh',
        'phuong_xa',
        'dia_chi_chi_tiet',
        'lat',
        'lng',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function setAsDefault(): self
    {
        static::where('nguoi_dung_id', $this->nguoi_dung_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->update(['is_default' => true]);

        return $this;
    }

    public static function getDefaultForUser(int $userId): ?self
    {
        return static::where('nguoi_dung_id', $userId)
            ->where('is_default', true)
            ->first() ?? static::where('nguoi_dung_id', $userId)->first();
    }
}