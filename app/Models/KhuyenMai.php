<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyen_mai';
    public $incrementing = false;
    protected $fillable = ['id', 'tenkhuyenmai', 'thoigianbatdau', 'thoigianketthuc', 'mota', 'trangthai'];
}
