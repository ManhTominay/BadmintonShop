<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    protected $table = 'thuong_hieu';
    public $timestamps = false;

    protected $fillable = ['ten_thuong_hieu', 'slug', 'logo', 'mo_ta'];
}