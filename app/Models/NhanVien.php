<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class NhanVien extends Authenticatable
{
    use Notifiable;

    protected $table = 'nhan_vien';
    public $incrementing = false;
    protected $fillable = [
        'id', 'tennhanvien', 'sdt', 'diachi', 'email', 'ngaysinh', 'gioitinh',
        'hinhanh', 'luong', 'tentaikhoan', 'password', 'id_loainhanvien', 'trangthai'
    ];
}
