<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chi_tiet_hoa_don';
    public $incrementing = false;
    protected $fillable = ['id_hoadon', 'id_chitietsanpham', 'soluong', 'giamgia', 'tonggia'];
}
