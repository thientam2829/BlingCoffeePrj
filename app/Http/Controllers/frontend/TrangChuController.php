<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\QuyCach;
use App\Models\ChiTietSanPham;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrangChuController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        // lấy ra sản phẩm "cà phê hạt" với quy cách = 2.
        $QuyCach = QuyCach::where('quy_cach.trangthai', 2)
            ->join('loai_san_pham', 'quy_cach.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('loai_san_pham.tenloaisanpham', '=', 'Cà Phê Hạt')
            ->select(
                'quy_cach.*',
            )->first();
        if ($QuyCach != null) {
            $IDQuyCach = $QuyCach->id;
        } else {
            $IDQuyCach = '1';
        }
        $viewData = [  // lấy ra sản phẩm "cà phê hạt" đang "bán chạy nhất" với quy cách = 2.
            'CaPheHatBanChayNhat' => SanPham::where([['san_pham.the', '=', 'BÁN CHẠY NHẤT'], ['san_pham.trangthai', 1]])
                ->join('loai_san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
                ->where([['loai_san_pham.tenloaisanpham', '=', 'Cà Phê Hạt'], ['loai_san_pham.trangthai', '!=', 0]])  // lấy loại cà phê hạt.
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    ['chi_tiet_san_pham.hansudung', '>=', $today],
                    ['chi_tiet_san_pham.soluong', '>', 0],
                    ['chi_tiet_san_pham.kichthuoc', '=', $IDQuyCach],
                ])
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the', // thẻ = bán chạy nhất.
                    'loai_san_pham.tenloaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                )->get(),
        ];
        return view('frontend.TrangChu.index', $viewData);
    }
}
