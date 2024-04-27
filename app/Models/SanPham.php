<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table ='san_pham';
    public $incrementing = false;
    protected $fillable = ['id', 'tensanpham', 'hinhanh', 'mota', 'the', 'id_loaisanpham', 'trangthai'];
}
