<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khach_hang';
    public $incrementing = false;
    protected $fillable = ['id', 'tenkhachhang', 'sdt', 'diachi', 'email', 'diemtichluy', 'trangthai'];
}
