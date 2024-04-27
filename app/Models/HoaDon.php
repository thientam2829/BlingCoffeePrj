<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoa_don';
    public $incrementing = false;
    protected $fillable = [
        'id', 'ngaylap', 'tongtienhoadon', 'giamgia', 'thanhtien', 'diemtichluy', 'tenkhachhang',
        'sdtkhachhang', 'diachikhachhang', 'emailkhachhang', 'ghichukhachhang',
        'id_khachhang', 'id_nhanvien','hinhthucthanhtoan', 'trangthai'
    ];
}
