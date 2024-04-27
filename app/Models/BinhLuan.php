<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binh_luan';
    public $incrementing = false;
    protected $fillable = [
        'id', 'hoten', 'gioitinh', 'noidung', 'email', 'id_sanpham',
        'thoigian', 'matraloi', 'trangthai'
    ];
}
