<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiNhanVien extends Model
{
    protected $table = 'loai_nhan_vien';
    public $incrementing = false;
    protected $fillable = ['id', 'tenloainhanvien', 'trangthai'];
}
