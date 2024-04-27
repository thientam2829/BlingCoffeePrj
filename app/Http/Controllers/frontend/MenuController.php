<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\QuyCach;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $LoaiSanPham = LoaiSanPham::where([['tenloaisanpham', 'Nước Uống'], ['trangthai', '!=', 0]])
            ->orWhere([['tenloaisanpham', 'Bánh'], ['trangthai', '!=', 0]])
            ->select(
                'id',
                'tenloaisanpham',
            )
            ->get();
        if (count($LoaiSanPham) > 1) {
            foreach ($LoaiSanPham as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDLoaiSanPham[] = $item->id;
            }
        } else {
            $IDLoaiSanPham[] = '1';
        }
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
        $viewData = [
            'LoaiSanPham' => $LoaiSanPham,
            'Menu' => SanPham::where('san_pham.trangthai', 1) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->whereIn('loai_san_pham.id', $IDLoaiSanPham)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    ['chi_tiet_san_pham.hansudung', '>=', $today],
                    ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.mota',
                    // 'san_pham.the',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                    'loai_san_pham.tenloaisanpham',
                )
                ->get(),
            'CaPheHat' => SanPham::where('san_pham.trangthai', 1)
                ->join('loai_san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
                ->where([['loai_san_pham.tenloaisanpham', '=', 'Cà Phê Hạt'], ['loai_san_pham.trangthai', '!=', 0]])
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
        // dd($viewData);
        return view('frontend.Menu.index', $viewData);
    }
}
