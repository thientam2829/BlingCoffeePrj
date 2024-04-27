<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
    protected $table = 'loai_san_pham';
    public $incrementing = false;
    protected $fillable = ['id', 'tenloaisanpham', 'trangthai'];
}
