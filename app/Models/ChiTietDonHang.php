<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
	protected $table = 'chi_tiet_don_hang';

	protected $fillable = [
		'don_hang_id',
		'san_pham_id',
		'bien_the_id',
		'so_luong',
		'gia',
		'thanh_tien',
	];

	public function sanPham()
	{
		return $this->belongsTo(SanPham::class, 'san_pham_id');
	}

	public function bienThe()
	{
		return $this->belongsTo(BienTheSanPham::class, 'bien_the_id');
	}
}
