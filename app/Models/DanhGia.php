<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';
    public $incrementing = false;
    protected $fillable = [
        'id', 'hoten', 'gioitinh', 'noidung', 'email', 'id_sanpham',
        'thoigian', 'sosao', 'trangthai'
    ];
}
