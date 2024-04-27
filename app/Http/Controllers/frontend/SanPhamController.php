<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BinhLuan;
use App\Models\SanPham;
use App\Models\ChiTietSanPham;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\DanhGia;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SanPhamController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $KhuyenMai = KhuyenMai::where([ // lấy tất cả km đang áp dụng.
            ['khuyen_mai.trangthai', '!=', '0'],
            ['khuyen_mai.thoigianketthuc', '>=', $today],
            ['khuyen_mai.thoigianbatdau', '<=', $today],
        ])
            ->select(
                'khuyen_mai.id',
                'khuyen_mai.tenkhuyenmai',
                'khuyen_mai.thoigianbatdau',
                'khuyen_mai.thoigianketthuc',
                'khuyen_mai.mota',
            )
            ->orderBy('created_at', 'asc')->get();
        if (count($KhuyenMai) > 0) {
            foreach ($KhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDKhuyenMai[] = $item->id;
            }
        } else {
            $IDKhuyenMai[] = '1';
        }
        $SanPhamKhuyenMai = ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
            ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
            ->where([ // kiểm tra chi tiết sản phảm.
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('san_pham.id', 'san_pham.the',)
            ->groupBy('san_pham.id', 'san_pham.the',)
            ->get();

        $LoaiSanPham = LoaiSanPham::where('loai_san_pham.trangthai', '!=', 0)
            ->join('san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('san_pham.trangthai', 1)
            ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where([
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('quy_cach.trangthai', 2)
            ->select('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->groupBy('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->get();
        if (count($LoaiSanPham) > 0) {
            foreach ($LoaiSanPham as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDLoaiSanPham[] = $item->id;
            }
        } else {
            $IDLoaiSanPham[] = '1';
        }
        $viewData = [
            'KhuyenMai' =>  $KhuyenMai,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'LoaiSanPham' => $LoaiSanPham,
            'SanPham' => SanPham::where('san_pham.trangthai', 1) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->whereIn('loai_san_pham.id', $IDLoaiSanPham)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    // ['chi_tiet_san_pham.hansudung', '>=', $today],
                    // ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),
        ];
        return view('frontend.SanPham.index', $viewData);
    }

    public function show($id) // xem chi tiết. {sản phẩm đã được kiểm tra trạng thái bằng 1 ở những nơi liên kết đến}
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $CTSP = ChiTietSanPham::where([
            ['chi_tiet_san_pham.id_sanpham', $id],
            ['chi_tiet_san_pham.hansudung', '>=', $today],
            ['chi_tiet_san_pham.trangthai', '=', '1'],
            ['chi_tiet_san_pham.soluong', '>', '0'],
        ])->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('chi_tiet_san_pham.*')
            ->orderBy('quy_cach.trangthai', 'desc')->get(); // lấy CTKM-> id SP,HSD, TT=1, SL>0 và sắp xếp giá giảm dần
        if (count($CTSP) > 0) {
            foreach ($CTSP as $key => $item) { // sử dụng từng CTSP để lấy khuyến mãi được tạo trước và đang áp dụng.
                $COKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                    ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                    ->Join('chi_tiet_khuyen_mai', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
                    ->Join('khuyen_mai', 'chi_tiet_khuyen_mai.id_khuyenmai', '=', 'khuyen_mai.id')
                    ->where([
                        ['khuyen_mai.trangthai', '!=', '0'],
                        ['khuyen_mai.thoigianketthuc', '>=', $today],
                        ['khuyen_mai.thoigianbatdau', '<=', $today],
                    ])
                    ->select(
                        'chi_tiet_san_pham.id',
                        'chi_tiet_san_pham.giasanpham',
                        'quy_cach.tenquycach',
                        'chi_tiet_khuyen_mai.muckhuyenmai',
                    )
                    ->orderBy('khuyen_mai.created_at', 'asc')
                    ->first();
                if ($COKM != null) { // nếu đúng kiều kiện có KM.
                    $ArrayCTSP[] =  $COKM;
                } else { // không có khuyến mãi.
                    $KOKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                        ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                        ->select(
                            'chi_tiet_san_pham.id',
                            'chi_tiet_san_pham.giasanpham',
                            'quy_cach.tenquycach',
                        )
                        ->first();
                    $ArrayCTSP[] =  $KOKM;
                }
            }
        }
        else{
            $ArrayCTSP[] =  null;
        } 
        $SanPham = SanPham::find($id);
        $viewData = [
            'ChiTietSanPham' => $ArrayCTSP,
            'SanPham' => $SanPham,
            'SanPhamLienQuang' => SanPham::where('san_pham.trangthai', 1) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.id', '=', $SanPham->id_loaisanpham)
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
                    'san_pham.the',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),
            'CountBinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->count(),
            'BinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->take(5)->get(),
            'TraLoi' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '!=', null], ['trangthai', '!=', 0]])->get(),
            'DanhGia' => DanhGia::where([['id_sanpham', $SanPham->id], ['trangthai', '=', 1]])->orderBy('thoigian', 'desc')->get(),
        ];
        return view('frontend.SanPham.show', $viewData);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword == "") {
            return redirect()->route('SanPham.index');
        }
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $KhuyenMai = KhuyenMai::where([ // lấy tất cả km đang áp dụng.
            ['khuyen_mai.trangthai', '!=', '0'],
            ['khuyen_mai.thoigianketthuc', '>=', $today],
            ['khuyen_mai.thoigianbatdau', '<=', $today],
        ])
            ->select(
                'khuyen_mai.id',
                'khuyen_mai.tenkhuyenmai',
                'khuyen_mai.thoigianbatdau',
                'khuyen_mai.thoigianketthuc',
                'khuyen_mai.mota',
            )
            ->orderBy('created_at', 'asc')->get();
        if (count($KhuyenMai) > 0) {
            foreach ($KhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDKhuyenMai[] = $item->id;
            }
        } else {
            $IDKhuyenMai[] = '1';
        }
        $LoaiSanPham = LoaiSanPham::where('loai_san_pham.trangthai', '!=', 0)
            ->join('san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('san_pham.trangthai', 1)
            ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where([
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('quy_cach.trangthai', 2)
            ->select('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->groupBy('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->get();
        $SanPhamKhuyenMai = ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
            ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
            ->where([ // kiểm tra chi tiết sản phảm.
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('san_pham.id', 'san_pham.the',)
            ->groupBy('san_pham.id', 'san_pham.the',)
            ->get();
        $viewData = [
            'keyword' => $keyword,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'KhuyenMai' =>  $KhuyenMai,
            'LoaiSanPham' => $LoaiSanPham,
            'Search' => SanPham::where([['tensanpham', 'like', '%' . $keyword . '%'], ['san_pham.trangthai', 1]]) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.trangthai', '!=', 0)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    // ['chi_tiet_san_pham.hansudung', '>=', $today],
                    // ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),

        ];
        return view('frontend.SanPham.index', $viewData);
    }

    public function filter($id)
    {
        $keyword = LoaiSanPham::find($id);
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $KhuyenMai = KhuyenMai::where([ // lấy tất cả km đang áp dụng.
            ['khuyen_mai.trangthai', '!=', '0'],
            ['khuyen_mai.thoigianketthuc', '>=', $today],
            ['khuyen_mai.thoigianbatdau', '<=', $today],
        ])
            ->select(
                'khuyen_mai.id',
                'khuyen_mai.tenkhuyenmai',
                'khuyen_mai.thoigianbatdau',
                'khuyen_mai.thoigianketthuc',
                'khuyen_mai.mota',
            )
            ->orderBy('created_at', 'asc')->get();
        if (count($KhuyenMai) > 0) {
            foreach ($KhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDKhuyenMai[] = $item->id;
            }
        } else {
            $IDKhuyenMai[] = '1';
        }
        $LoaiSanPham = LoaiSanPham::where('loai_san_pham.trangthai', '!=', 0)
            ->join('san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('san_pham.trangthai', 1)
            ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where([
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('quy_cach.trangthai', 2)
            ->select('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->groupBy('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->get();
        $SanPhamKhuyenMai = ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
            ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
            ->where([ // kiểm tra chi tiết sản phảm.
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('san_pham.id', 'san_pham.the',)
            ->groupBy('san_pham.id', 'san_pham.the',)
            ->get();
        $viewData = [
            'keyword' => $keyword->tenloaisanpham,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'KhuyenMai' =>  $KhuyenMai,
            'LoaiSanPham' => $LoaiSanPham,
            'Filter' => SanPham::where('san_pham.trangthai', 1) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.id', '=', $keyword->id)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    // ['chi_tiet_san_pham.hansudung', '>=', $today],
                    // ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),

        ];
        return view('frontend.SanPham.index', $viewData);
    }

    public function tag($tag)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $KhuyenMai = KhuyenMai::where([ // lấy tất cả km đang áp dụng.
            ['khuyen_mai.trangthai', '!=', '0'],
            ['khuyen_mai.thoigianketthuc', '>=', $today],
            ['khuyen_mai.thoigianbatdau', '<=', $today],
        ])
            ->select(
                'khuyen_mai.id',
                'khuyen_mai.tenkhuyenmai',
                'khuyen_mai.thoigianbatdau',
                'khuyen_mai.thoigianketthuc',
                'khuyen_mai.mota',
            )
            ->orderBy('created_at', 'asc')->get();
        if (count($KhuyenMai) > 0) {
            foreach ($KhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDKhuyenMai[] = $item->id;
            }
        } else {
            $IDKhuyenMai[] = '1';
        }
        $LoaiSanPham = LoaiSanPham::where('loai_san_pham.trangthai', '!=', 0)
            ->join('san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('san_pham.trangthai', 1)
            ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where([
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('quy_cach.trangthai', 2)
            ->select('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->groupBy('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->get();
        $SanPhamKhuyenMai = ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
            ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
            ->where([ // kiểm tra chi tiết sản phảm.
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('san_pham.id', 'san_pham.the',)
            ->groupBy('san_pham.id', 'san_pham.the',)
            ->get();
        $viewData = [
            'keyword' => $tag,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'KhuyenMai' =>  $KhuyenMai,
            'LoaiSanPham' => $LoaiSanPham,
            'Filter' => SanPham::where([['san_pham.the', 'like', '%' . $tag . '%'], ['san_pham.trangthai', 1]]) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.trangthai', '!=', 0)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    // ['chi_tiet_san_pham.hansudung', '>=', $today],
                    // ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),

        ];
        return view('frontend.SanPham.index', $viewData);
    }

    public function sale()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $KhuyenMai = KhuyenMai::where([
            ['khuyen_mai.trangthai', '!=', '0'],
            ['khuyen_mai.thoigianketthuc', '>=', $today],
            ['khuyen_mai.thoigianbatdau', '<=', $today],
        ])
            ->select(
                'khuyen_mai.id',
                'khuyen_mai.tenkhuyenmai',
                'khuyen_mai.thoigianbatdau',
                'khuyen_mai.thoigianketthuc',
                'khuyen_mai.mota',
            )
            ->orderBy('created_at', 'asc')->get();
        if (count($KhuyenMai) > 0) {
            foreach ($KhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDKhuyenMai[] = $item->id;
            }
        } else {
            $IDKhuyenMai[] = '1';
        }
        $LoaiSanPham = LoaiSanPham::where('loai_san_pham.trangthai', '!=', 0)
            ->join('san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
            ->where('san_pham.trangthai', 1)
            ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where([
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('quy_cach.trangthai', 2)
            ->select('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->groupBy('loai_san_pham.id', 'loai_san_pham.tenloaisanpham')
            ->get();
        $SanPhamKhuyenMai = ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
            ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
            ->where([ // kiểm tra chi tiết sản phảm.
                ['chi_tiet_san_pham.trangthai', '=', 1],
                ['chi_tiet_san_pham.hansudung', '>=', $today],
                ['chi_tiet_san_pham.soluong', '>', 0],
            ])
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('san_pham.id', 'san_pham.the')
            ->groupBy('san_pham.id', 'san_pham.the')
            ->get();

        if (count($SanPhamKhuyenMai) > 0) {
            foreach ($SanPhamKhuyenMai as $key => $item) { // tạo mảng id để sử dụng where in.
                $IDSanPhamKhuyenMai[] = $item->id;
            }
        } else {
            $IDSanPhamKhuyenMai[] = '1';
        }
        $viewData = [
            'KhuyenMai' =>  $KhuyenMai,
            'LoaiSanPham' => $LoaiSanPham,
            // 'KTSale' =>  $KTSale,
            'GiaSP' => SanPham::whereIn('san_pham.id', $IDSanPhamKhuyenMai) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.trangthai', '!=', 0)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    // ['chi_tiet_san_pham.hansudung', '>=', $today],
                    // ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->where('quy_cach.trangthai', 2)
                ->select(
                    'san_pham.id',
                    'chi_tiet_san_pham.giasanpham',
                )
                ->get(),
            'Sale' => ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
                ->join('chi_tiet_san_pham', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
                ->where([ // kiểm tra chi tiết sản phảm.
                    ['chi_tiet_san_pham.trangthai', '=', 1],
                    ['chi_tiet_san_pham.hansudung', '>=', $today],
                    ['chi_tiet_san_pham.soluong', '>', 0],
                ])
                ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where('san_pham.trangthai', 1) // kiểm tra sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.trangthai', '!=', 0) // kiểm tra loại sản phẩm.
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'san_pham.id',
                    'chi_tiet_khuyen_mai.id_khuyenmai',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                )
                ->groupBy(
                    'san_pham.id',
                    'chi_tiet_khuyen_mai.id_khuyenmai',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                    'san_pham.sosao',
                )
                ->get(),

        ];
        return view('frontend.SanPham.index', $viewData);
    }

    public function showProduct($id)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $CTSP = ChiTietSanPham::where([
            ['chi_tiet_san_pham.id_sanpham', $id],
            ['chi_tiet_san_pham.hansudung', '>=', $today],
            ['chi_tiet_san_pham.trangthai', '=', '1'],
            ['chi_tiet_san_pham.soluong', '>', '0'],
        ])->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('chi_tiet_san_pham.*')
            ->orderBy('quy_cach.trangthai', 'desc')->get(); // lấy CTKM-> id SP,HSD, TT=1, SL>0 và sắp xếp giá giảm dần
        if (count($CTSP) > 0) {
            foreach ($CTSP as $key => $item) { // sử dụng từng CTSP để lấy khuyến mãi được tạo trước và đang áp dụng.
                $COKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                    ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                    ->Join('chi_tiet_khuyen_mai', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
                    ->Join('khuyen_mai', 'chi_tiet_khuyen_mai.id_khuyenmai', '=', 'khuyen_mai.id')
                    ->where([
                        ['khuyen_mai.trangthai', '!=', '0'],
                        ['khuyen_mai.thoigianketthuc', '>=', $today],
                        ['khuyen_mai.thoigianbatdau', '<=', $today],
                    ])
                    ->select(
                        'chi_tiet_san_pham.id',
                        'chi_tiet_san_pham.giasanpham',
                        'quy_cach.tenquycach',
                        'chi_tiet_khuyen_mai.muckhuyenmai',
                    )
                    ->orderBy('khuyen_mai.created_at', 'asc')
                    ->first();
                if ($COKM != null) { // nếu đúng kiều kiện có KM.
                    $ArrayCTSP[] =  $COKM;
                } else { // không có khuyến mãi.
                    $KOKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                        ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                        ->select(
                            'chi_tiet_san_pham.id',
                            'chi_tiet_san_pham.giasanpham',
                            'quy_cach.tenquycach',
                        )
                        ->first();
                    $ArrayCTSP[] =  $KOKM;
                }
            }
        }else{
            $ArrayCTSP[] =  null;
        }
        $SanPham = SanPham::find($id);
        $viewData = [
            'ChiTietSanPham' => $ArrayCTSP,
            'SanPham' => $SanPham,
        ];
        return view('frontend.SanPham.showProduct', $viewData);
    }

    public function comment($id) // xem chi tất cả bình luận của sản phẩm.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $CTSP = ChiTietSanPham::where([
            ['chi_tiet_san_pham.id_sanpham', $id],
            ['chi_tiet_san_pham.hansudung', '>=', $today],
            ['chi_tiet_san_pham.trangthai', '=', '1'],
            ['chi_tiet_san_pham.soluong', '>', '0'],
        ])->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('chi_tiet_san_pham.*')
            ->orderBy('quy_cach.trangthai', 'desc')->get(); // lấy CTKM-> id SP,HSD, TT=1, SL>0 và sắp xếp giá giảm dần
        if ($CTSP != null) {
            foreach ($CTSP as $key => $item) { // sử dụng từng CTSP để lấy khuyến mãi được tạo trước và đang áp dụng.
                $COKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                    ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                    ->Join('chi_tiet_khuyen_mai', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
                    ->Join('khuyen_mai', 'chi_tiet_khuyen_mai.id_khuyenmai', '=', 'khuyen_mai.id')
                    ->where([
                        ['khuyen_mai.trangthai', '!=', '0'],
                        ['khuyen_mai.thoigianketthuc', '>=', $today],
                        ['khuyen_mai.thoigianbatdau', '<=', $today],
                    ])
                    ->select(
                        'chi_tiet_san_pham.id',
                        'chi_tiet_san_pham.giasanpham',
                        'quy_cach.tenquycach',
                        'chi_tiet_khuyen_mai.muckhuyenmai',
                    )
                    ->orderBy('khuyen_mai.created_at', 'asc')
                    ->first();
                if ($COKM != null) { // nếu đúng kiều kiện có KM.
                    $ArrayCTSP[] =  $COKM;
                } else { // không có khuyến mãi.
                    $KOKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                        ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                        ->select(
                            'chi_tiet_san_pham.id',
                            'chi_tiet_san_pham.giasanpham',
                            'quy_cach.tenquycach',
                        )
                        ->first();
                    $ArrayCTSP[] =  $KOKM;
                }
            }
        }
        $SanPham = SanPham::find($id);
        $viewData = [
            'ChiTietSanPham' => $ArrayCTSP,
            'SanPham' => $SanPham,
            'SanPhamLienQuang' => SanPham::where('san_pham.trangthai', 1) // lấy ra thông tin sản phẩm.
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.id', '=', $SanPham->id_loaisanpham)
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
                    'san_pham.the',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),
            'CountBinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->count(),
            'BinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->paginate(10),
            'TraLoi' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '!=', null], ['trangthai', '!=', 0]])->get(),
            'DanhGia' => DanhGia::where([['id_sanpham', $SanPham->id], ['trangthai', '=', 1]])->orderBy('thoigian', 'desc')->get(),
        ];
        return view('frontend.SanPham.comment', $viewData);
    }
    public function review($id) // xem chi tất cả bình luận của sản phẩm.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $CTSP = ChiTietSanPham::where([
            ['chi_tiet_san_pham.id_sanpham', $id],
            ['chi_tiet_san_pham.hansudung', '>=', $today],
            ['chi_tiet_san_pham.trangthai', '=', '1'],
            ['chi_tiet_san_pham.soluong', '>', '0'],
        ])->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select('chi_tiet_san_pham.*')
            ->orderBy('quy_cach.trangthai', 'desc')->get(); // lấy CTKM-> id SP,HSD, TT=1, SL>0 và sắp xếp giá giảm dần
        if ($CTSP != null) {
            foreach ($CTSP as $key => $item) { // sử dụng từng CTSP để lấy khuyến mãi được tạo trước và đang áp dụng.
                $COKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                    ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                    ->Join('chi_tiet_khuyen_mai', 'chi_tiet_khuyen_mai.id_chitietsanpham', '=', 'chi_tiet_san_pham.id')
                    ->Join('khuyen_mai', 'chi_tiet_khuyen_mai.id_khuyenmai', '=', 'khuyen_mai.id')
                    ->where([
                        ['khuyen_mai.trangthai', '!=', '0'],
                        ['khuyen_mai.thoigianketthuc', '>=', $today],
                        ['khuyen_mai.thoigianbatdau', '<=', $today],
                    ])
                    ->select(
                        'chi_tiet_san_pham.id',
                        'chi_tiet_san_pham.giasanpham',
                        'quy_cach.tenquycach',
                        'chi_tiet_khuyen_mai.muckhuyenmai',
                    )
                    ->orderBy('khuyen_mai.created_at', 'asc')
                    ->first();
                if ($COKM != null) { // nếu đúng kiều kiện có KM.
                    $ArrayCTSP[] =  $COKM;
                } else { // không có khuyến mãi.
                    $KOKM = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id)
                        ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                        ->select(
                            'chi_tiet_san_pham.id',
                            'chi_tiet_san_pham.giasanpham',
                            'quy_cach.tenquycach',
                        )
                        ->first();
                    $ArrayCTSP[] =  $KOKM;
                }
            }
        }
        $SanPham = SanPham::find($id);
        $CountDanhGia = DanhGia::where([['id_sanpham', $SanPham->id], ['trangthai', '=', 1]])->orderBy('thoigian', 'desc')->count();
        if ($CountDanhGia > 0) {
            for ($i = 1; $i < 6; $i++) {
                $SoSao = DanhGia::where([['sosao', $i], ['id_sanpham', $SanPham->id], ['trangthai', '=', 1]])->orderBy('thoigian', 'desc')->count();
                $PhanTram = ($SoSao / ($CountDanhGia / 100));

                $ArraySoSao[] = round($PhanTram, 0, PHP_ROUND_HALF_UP);
            }
        } else {
            $ArraySoSao =  'nulls';
        }
        $viewData = [
            'ChiTietSanPham' => $ArrayCTSP,
            'SanPham' => $SanPham,
            'SanPhamLienQuang' => SanPham::where('san_pham.trangthai', 1)
                ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
                ->where('loai_san_pham.id', '=', $SanPham->id_loaisanpham)
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([
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
                    'san_pham.the',
                    'san_pham.id_loaisanpham',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                )
                ->get(),
            'CountBinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->count(),
            'BinhLuan' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '=', null], ['trangthai', '!=', 0]])->orderBy('created_at', 'desc')->paginate(10),
            'TraLoi' => BinhLuan::where([['id_sanpham', $SanPham->id], ['matraloi', '!=', null], ['trangthai', '!=', 0]])->get(),
            'CountDanhGia' => $CountDanhGia,
            'ArraySoSao' => $ArraySoSao,
            'DanhGia' => DanhGia::where([['id_sanpham', $SanPham->id], ['trangthai', '=', 1]])->orderBy('thoigian', 'desc')->paginate(10),
        ];
        return view('frontend.SanPham.review', $viewData);
    }
}
