<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\ChiTietSanPham;
use App\Models\QuyCach;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\LoaiSanPham;
use App\Models\NhanVien;
use App\Models\KhachHang;
use App\Models\HoaDonOnline;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VeChungToiController extends Controller
{
    public function index()
    {
        $viewData = [
            'NhanVien' => NhanVien::all(),
            'KhachHang' => KhachHang::all(),
            'HoaDon' => HoaDon::all(),
            'KhuyenMai' => KhuyenMai::all(),
        ];
        return view('frontend.VeChungToi.index', $viewData);
    }
}
