<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietKhuyenMai extends Model
{
    protected $table = 'chi_tiet_khuyen_mai';
    public $incrementing = false;
    protected $fillable = ['id_chitietsanpham', 'id_khuyenmai', 'muckhuyenmai'];
}
