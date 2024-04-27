<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongKe;
use App\Models\SanPham;
use App\Models\NhanVien;
use App\Models\KhachHang;
use App\Models\HoaDon;
use App\Models\KhuyenMai;
use App\Models\LoaiSanPham;
use App\Models\LoaiNhanVien;
use App\Models\ChiTietHoaDon;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function index() //thống kê.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $viewData = [
            'SanPham' => SanPham::where('trangthai', '!=', 0)->count(),
            'NhanVien' => NhanVien::where('trangthai', '!=', 0)->count(),
            'KhachHang' => KhachHang::count(),
            'KhachHangTop10' => KhachHang::where('id', '!=', 'KH00000000000000')->select('tenkhachhang', 'diemtichluy')->orderBy('diemtichluy', 'desc')->limit(10)->get(),
            'KhuyenMai' => KhuyenMai::count(),
            'KhuyenMaiDangApDung' => KhuyenMai::where([['thoigianbatdau', '<=', $today], ['thoigianketthuc', '>=', $today], ['trangthai', 1]])->orderBy('created_at', 'asc')->get(),
            'KhuyenMaiSapDen' => KhuyenMai::where([['thoigianbatdau', '>', $today], ['trangthai', 1]])->orderBy('created_at', 'asc')->get(),
            'HoaDon' => HoaDon::count(),
        ];
        return view('backend.ThongKe.index', $viewData);
    }

    public function fromto(Request $request) //thống kê trong khoản thời gian.
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($fromdate > $todate) {
            return Response()->json(['errors' => 'Ngày Bắt Đầu Không Được Nhỏ Hơn Ngày Kết Thúc']);
        }
        $ThongKe = ThongKe::whereBetween('thoigian', [$fromdate, $todate])->orderBy('thoigian', 'asc')->get();

        foreach ($ThongKe as $key => $value) {
            $date = date_create($value->thoigian);
            $chart_data[] = array(
                'thoigian' => date_format($date, "d-m-Y"),
                'doanhso' => $value->doanhso,
                'loinhuan' => $value->loinhuan,
                'soluongdaban' => $value->soluongdaban,
                'soluongdonhang' => $value->soluongdonhang,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function statsForThisMonth() //thống kê trong khoản thời gian.
    {
        $ThongKe = ThongKe::orderBy('thoigian', 'desc')->take(6)->get();
        foreach ($ThongKe as $key => $value) {
            $date = date_create($value->thoigian);
            $chart_data[] = array(
                'thoigian' => date_format($date, "d-m-Y"),
                'doanhso' => $value->doanhso,
                'loinhuan' => $value->loinhuan,
                'soluongdaban' => $value->soluongdaban,
                'soluongdonhang' => $value->soluongdonhang,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function product() //thống kê sản phẩm.
    {
        $LoaiSanPham = LoaiSanPham::where('trangthai', '!=', 0)->get();
        foreach ($LoaiSanPham as $item) {
            $SanPham = SanPham::where([['id_loaisanpham', $item->id], ['trangthai', '!=', 0]])->count();
            $chart_data[] = array(
                'label' => $item->tenloaisanpham,
                'value' => $SanPham,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function customer() //thống kê khách hàng.
    {
        $khachHang1  = KhachHang::whereBetween('diemtichluy', [0, 999])->where('id', '!=', 'KH00000000000000')->count();
        $chart_data[] = array('label' => '0 - 999 Điểm', 'value' => $khachHang1);
        $khachHang2  = KhachHang::whereBetween('diemtichluy', [1000, 4999])->where('id', '!=', 'KH00000000000000')->count();
        $chart_data[] = array('label' => '1.000 - 4.999 Điểm', 'value' => $khachHang2);
        $khachHang3  = KhachHang::whereBetween('diemtichluy', [5000, 9999])->where('id', '!=', 'KH00000000000000')->count();
        $chart_data[] = array('label' => '5.000 - 9.999 Điểm', 'value' => $khachHang3);
        $khachHang4  = KhachHang::whereBetween('diemtichluy', [10000, 99999])->where('id', '!=', 'KH00000000000000')->count();
        $chart_data[] = array('label' => '10.000 - 99.999 Điểm', 'value' => $khachHang4);
        $khachHang5  = KhachHang::where('diemtichluy', '>=', 100000)->where('id', '!=', 'KH00000000000000')->count();
        $chart_data[] = array('label' => 'Từ 100.000 Điểm Trở Lên', 'value' => $khachHang5);
        echo $data = json_encode($chart_data);
    }

    public function satff() //thống kê sản phẩm.
    {
        $LoaiNhanVien = LoaiNhanVien::where([['id', '!=', 'LNV00000000000000'], ['trangthai', '!=', 0]])->get();
        foreach ($LoaiNhanVien as $item) {
            $NhanVien = NhanVien::where([['id_loainhanvien', $item->id], ['trangthai', '!=', 0]])->count();
            $chart_data[] = array(
                'label' => $item->tenloainhanvien,
                'value' => $NhanVien,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function bill() //thống kê sản phẩm.
    {
        $HoaDon  = HoaDon::where([['id_nhanvien', '!=', 'NV11111111111111'], ['trangthai', '!=', 3]])->count();
        $chart_data[] = array('label' => 'Mua Tại Cửa Hàng', 'value' => $HoaDon);
        $HoaDon  = HoaDon::where([['id_nhanvien', '=', 'NV11111111111111'], ['trangthai', '!=', 3]])->count();
        $chart_data[] = array('label' => 'Mua Online', 'value' => $HoaDon);
        $HoaDon  = HoaDon::where([['trangthai', '=', 3]])->count();
        $chart_data[] = array('label' => 'Hóa Đơn Đã Hủy', 'value' => $HoaDon);
        echo $data = json_encode($chart_data);
    }
}
