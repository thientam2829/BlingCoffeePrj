<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongKe extends Model
{
    protected $table = 'thong_ke';
    public $incrementing = false;
    protected $fillable = ['id', 'thoigian', 'doanhso', 'loinhuan', 'soluongdaban', 'soluongdonhang'];
}
