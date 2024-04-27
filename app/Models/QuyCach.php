<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuyCach extends Model
{
    protected $table = 'quy_cach';
    public $incrementing = false;
    protected $fillable = ['id', 'id_loaisanpham', 'tenquycach', 'trangthai'];
}
