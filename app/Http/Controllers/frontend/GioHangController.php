<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\ChiTietSanPham;
use App\Models\KhuyenMai;
use App\Models\QuyCach;
use App\Models\ChiTietKhuyenMai;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cart;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use Illuminate\Support\Facades\Session;

class GioHangController extends Controller
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
        if (Session('GioHangOnline') == null) {
            $viewData = [
                'CaPheHatBanChayNhat' => SanPham::where([['san_pham.the', '=', 'BÁN CHẠY NHẤT'], ['san_pham.trangthai', '!=', '0']])
                    ->join('loai_san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
                    ->where('loai_san_pham.tenloaisanpham', '=', 'Cà Phê Hạt')  // lấy loại cà phê hạt.
                    ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                    ->where('chi_tiet_san_pham.kichthuoc', '=', $IDQuyCach)
                    ->select(
                        'san_pham.id',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                        'san_pham.the', // thẻ = bán chạy nhất.
                        'loai_san_pham.tenloaisanpham',
                        'chi_tiet_san_pham.giasanpham',
                    )->get(),
            ];
        } else {
            $viewData = [];
        }
        return view('frontend.GioHang.index', $viewData);
    }

    public function show() // trang tiến hành thanh toán.
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
        $viewData = [
            'KhuyenMai' => ChiTietKhuyenMai::whereIn('chi_tiet_khuyen_mai.id_khuyenmai', $IDKhuyenMai) // lấy thông tin sản phẩm được khuyến mãi.
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
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                    'chi_tiet_khuyen_mai.id_chitietsanpham',
                    'chi_tiet_khuyen_mai.id_khuyenmai',
                    'chi_tiet_khuyen_mai.muckhuyenmai',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'san_pham.the',
                )
                ->get(),

        ];
        // dd($viewData);
        return view('frontend.GioHang.show', $viewData);
    }

    function addCartOnline(Request $request) // thêm từ trang chi tiết.
    {
        $SL = $request->quantity; // số lượng được gửi qua.
        $ID = $request->id_product_details; // id chi tiết sản phẩm được gửi qua.
        $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $ID)
            ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'chi_tiet_san_pham.*',
                'quy_cach.tenquycach',
            )->first();
        $SanPham = SanPham::where('id', $ChiTietSanPham->id_sanpham)->first();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietKhuyenMai = ChiTietKhuyenMai::where('id_chitietsanpham', $ID)
            ->join('khuyen_mai', 'khuyen_mai.id', '=', 'chi_tiet_khuyen_mai.id_khuyenmai')
            ->where([
                ['khuyen_mai.trangthai', '!=', '0'],
                ['khuyen_mai.thoigianketthuc', '>=', $today],
                ['khuyen_mai.thoigianbatdau', '<=', $today],
            ])->select(
                'khuyen_mai.*',
                'chi_tiet_khuyen_mai.muckhuyenmai'
            )
            ->orderBy('created_at', 'asc')
            ->first(); // lấy khuyến mãi được Thêm vào đầu tiên.
        if ($ChiTietKhuyenMai != null) { // kiểm tra khuyến mãi.
            $ApDungKhuyenMai = $ChiTietKhuyenMai->muckhuyenmai; // gắn lạy phần trăm giảm giá.
        } else {
            $ApDungKhuyenMai = 0; // 0% nếu không tìm thấy chi tiết khuyến mãi.
        }

        $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null; // kiểm tra session và gắn lại khi đã có.
        $newCart = new Cart($odlCart); // khỏi tạo class Cart.

        if (!isset(Session('GioHangOnline')->products[$ID])) { // kiểm tra nếu chưa có.
            if ($SL > $ChiTietSanPham->soluong) {
                $SL1 = $ChiTietSanPham->soluong;
                $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL1); // gọi phương thức.
                $request->Session()->put('GioHangOnline', $newCart);
                return redirect()->route('SanPham.index')->with('warning', "Bạn Chỉ Có Thể Thêm " . $SL1 . " Sản Phẩm");
            }
        } else {
            if ($SL + Session('GioHangOnline')->products[$ID]['SoLuong'] > $ChiTietSanPham->soluong) {
                $SL1 = $ChiTietSanPham->soluong - Session('GioHangOnline')->products[$ID]['SoLuong'];
                if ($SL1 == 0) {
                    return redirect()->route('SanPham.index')->with('error', "Bạn Đã Thêm Tối Đa");
                }
                $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL1); // gọi phương thức.
                $request->Session()->put('GioHangOnline', $newCart);
                return redirect()->route('SanPham.index')->with('warning', "Bạn Chỉ Có Thể Thêm " . $SL1 . " Sản Phẩm");
            }
        }
        $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL); // gọi phương thức.
        $request->Session()->put('GioHangOnline', $newCart);
        return redirect()->route('SanPham.index')->with('message', "Đã Thêm " . $SL . " Sản Phẩm");
    }

    function addCart(Request $request)
    {
        $SL = $request->quantity; // số lượng được gửi qua.
        $ID = $request->id_product_details; // id chi tiết sản phẩm được gửi qua.
        $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $ID)
            ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'chi_tiet_san_pham.*',
                'quy_cach.tenquycach',
            )->first();
        $SanPham = SanPham::where('id', $ChiTietSanPham->id_sanpham)->first();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietKhuyenMai = ChiTietKhuyenMai::where('id_chitietsanpham', $ID)
            ->join('khuyen_mai', 'khuyen_mai.id', '=', 'chi_tiet_khuyen_mai.id_khuyenmai')
            ->where([
                ['khuyen_mai.trangthai', '!=', '0'],
                ['khuyen_mai.thoigianketthuc', '>=', $today],
                ['khuyen_mai.thoigianbatdau', '<=', $today],
            ])->select(
                'khuyen_mai.*',
                'chi_tiet_khuyen_mai.muckhuyenmai'
            )
            ->orderBy('created_at', 'asc')
            ->first(); // lấy khuyến mãi được Thêm vào đầu tiên.
        if ($ChiTietKhuyenMai != null) { // kiểm tra khuyến mãi.
            $ApDungKhuyenMai = $ChiTietKhuyenMai->muckhuyenmai; // gắn lạy phần trăm giảm giá.
        } else {
            $ApDungKhuyenMai = 0; // 0% nếu không tìm thấy chi tiết khuyến mãi.
        }

        $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null; // kiểm tra session và gắn lại khi đã có.
        $newCart = new Cart($odlCart); // khỏi tạo class Cart.

        if (!isset(Session('GioHangOnline')->products[$ID])) { // kiểm tra nếu chưa có.
            if ($SL > $ChiTietSanPham->soluong) {
                $SL1 = $ChiTietSanPham->soluong;
                $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL1); // gọi phương thức.
                $request->Session()->put('GioHangOnline', $newCart);
                $output = "
                <input type='text' name='soluongsanpham' id='soluongsanpham' value='" . Session('GioHangOnline')->totalQuanty . "' hidden>
                <input type='text' name='noidungthongbao' id='noidungthongbao' value='Bạn Chỉ Có Thể Thêm " . $SL1 . " Sản Phẩm' hidden>";
                return $output;
            }
        } else {
            if ($SL + Session('GioHangOnline')->products[$ID]['SoLuong'] > $ChiTietSanPham->soluong) {
                $SL1 = $ChiTietSanPham->soluong - Session('GioHangOnline')->products[$ID]['SoLuong'];
                if ($SL1 == 0) {
                    $output = "
                    <input type='text' name='soluongsanpham' id='soluongsanpham' value='" . Session('GioHangOnline')->totalQuanty . "' hidden>
                    <input type='text' name='noidungthongbao' id='noidungthongbao' value='Bạn Đã Thêm Tối Đa' hidden>";
                    return $output;
                }
                $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL1); // gọi phương thức.
                $request->Session()->put('GioHangOnline', $newCart);
                $output = "
                <input type='text' name='soluongsanpham' id='soluongsanpham' value='" . Session('GioHangOnline')->totalQuanty . "' hidden>
                <input type='text' name='noidungthongbao' id='noidungthongbao' value='Bạn Chỉ Có Thể Thêm " . $SL1 . " Sản Phẩm' hidden>";
                return $output;
            }
        }
        $newCart->addCartOnline($ID, $SanPham, $ChiTietSanPham, $ApDungKhuyenMai, $SL); // gọi phương thức.
        $request->Session()->put('GioHangOnline', $newCart);
        $output = "
        <input type='text' name='soluongsanpham' id='soluongsanpham' value='" . Session('GioHangOnline')->totalQuanty . "' hidden>
        <input type='text' name='noidungthongbao' id='noidungthongbao' value='Đã Thêm " . $SL . " Sản Phẩm' hidden>";
        return $output;
    }


    public function deleteItemCartOnline(Request $request, $id)
    {
        $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null;
        $newCart = new Cart($odlCart);
        $newCart->deleteItemCart($id);
        if (count($newCart->products) > 0) {
            $request->session()->put('GioHangOnline', $newCart);
        } else {
            $request->Session()->forget('GioHangOnline');
        }
        return true;
    }

    public function deleteCartOnline(Request $request)
    {
        $request->Session()->forget('GioHangOnline');
        return true;
    }

    public function updateQuantityOnline(Request $request)
    {
        foreach ($request->data as $item) {
            $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null;
            $newCart = new Cart($odlCart);
            $newCart->quantityChange($item['id'], $item['sl']);
            $request->session()->put('GioHangOnline', $newCart);
        }
        return true;
    }

    public function orderOnline(Request $request)
    {
        $KhachHang = KhachHang::where('sdt', $request->sdt)->first();
        if ($KhachHang != null) {
            /////////////////////////////////////////////////////////
            // lấy giảm giá thành viên.
            $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null;
            $newCart = new Cart($odlCart);
            $newCart->DiscountMember($KhachHang->diemtichluy, $KhachHang->sdt);
            $request->session()->put('GioHangOnline', $newCart);
            /////////////////////////////////////////////////////////
            // hóa đơn.
            $iddate = "HD" . Carbon::now('Asia/Ho_Chi_Minh');
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data['id'] = $imp;
            $data['ngaylap'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data['tongtienhoadon'] = Session::get('GioHangOnline')->totalPrice;
            $data['giamgia'] = Session::get('GioHangOnline')->totalDiscount;
            $data['thanhtien'] = Session::get('GioHangOnline')->Total;
            $data['diemtichluy'] = Session::get('GioHangOnline')->Total / 10000;
            $data['tenkhachhang'] = $request->hoten;
            $data['sdtkhachhang'] = $request->sdt;
            $data['diachikhachhang'] = $request->diachi;
            $data['emailkhachhang'] = $request->email;
            $data['ghichukhachhang'] = $request->ghichu;
            $data['id_khachhang'] = $KhachHang->id;
            $data['id_nhanvien'] = "NV11111111111111"; // tài khoản đặt hàng Online.
            $data['trangthai'] = 2; // trạng thái chờ xác nhận.
            HoaDon::create($data); //tạo hóa đơn.
        } else {
            $iddate = "HD" . Carbon::now('Asia/Ho_Chi_Minh');
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data['id'] = $imp;
            $data['ngaylap'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data['tongtienhoadon'] = Session::get('GioHangOnline')->totalPrice;
            $data['giamgia'] = Session::get('GioHangOnline')->totalDiscount;
            $data['thanhtien'] = Session::get('GioHangOnline')->Total;
            $data['tenkhachhang'] = $request->hoten;
            $data['emailkhachhang'] = $request->email;
            $data['sdtkhachhang'] = $request->sdt;
            $data['diachikhachhang'] = $request->diachi;
            $data['ghichukhachhang'] = $request->ghichu;
            $data['id_khachhang'] = "KH00000000000000";
            $data['id_nhanvien'] = "NV11111111111111"; // tài khoản đặt hàng Online.
            $data['trangthai'] = 2; // trạng thái chờ xác nhận.
            HoaDon::create($data); //tạo hóa đơn.
        }
        foreach (Session::get('GioHangOnline')->products as $item) { // tạo chi tiết hóa đơn.
            $data2['id_hoadon'] = $imp;
            $data2['id_chitietsanpham'] =  $item['CTSP']->id;
            $data2['soluong'] = $item['SoLuong'];
            $data2['giamgia'] = $item['GiamGia'];
            $data2['tonggia'] = $item['TongGia'];
            ChiTietHoaDon::create($data2); // tạo chi tiết hóa đơn.
        }
        $request->Session()->forget('GioHangOnline'); //xóa session GioHang khi hoàn tất.
        return redirect()->route('Trangchu.index')->with('success', 'Thành Công Rồi');
    }

    public function viewCart(Request $request) // xem lại giỏ hàng và giảm giá thành viên nếu có.
    {
        $KhachHang = KhachHang::where('sdt', $request->sdt)->first();
        $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null;
        $newCart = new Cart($odlCart);
        if ($KhachHang != null) {
            $newCart->DiscountMember($KhachHang->diemtichluy, $KhachHang->sdt);
            $request->session()->put('GioHangOnline', $newCart);
        } else {
            $newCart->DiscountMember(0, null);
            $request->session()->put('GioHangOnline', $newCart);
        }
        return view('frontend.GioHang.datacart');
    }


    public function checkOutPayPal(Request $request)
    {
        $KhachHang = KhachHang::where('sdt', $request->sdt)->first();
        if ($KhachHang != null) {
            /////////////////////////////////////////////////////////
            // lấy giảm giá thành viên.
            $odlCart = Session('GioHangOnline') ? Session('GioHangOnline') : null;
            $newCart = new Cart($odlCart);
            $newCart->DiscountMember($KhachHang->diemtichluy, $KhachHang->sdt);
            $request->session()->put('GioHangOnline', $newCart);
            /////////////////////////////////////////////////////////
            // hóa đơn.
            $iddate = "HD" . Carbon::now('Asia/Ho_Chi_Minh');
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data['id'] = $imp;
            $data['ngaylap'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data['tongtienhoadon'] = Session::get('GioHangOnline')->totalPrice;
            $data['giamgia'] = Session::get('GioHangOnline')->totalDiscount;
            $data['thanhtien'] = Session::get('GioHangOnline')->Total;
            $data['diemtichluy'] = Session::get('GioHangOnline')->Total / 10000;
            $data['tenkhachhang'] = $request->hoten;
            $data['sdtkhachhang'] = $request->sdt;
            $data['diachikhachhang'] = $request->diachi;
            $data['emailkhachhang'] = $request->email;
            $data['ghichukhachhang'] = $request->ghichu;
            $data['id_khachhang'] = $KhachHang->id;
            $data['id_nhanvien'] = "NV11111111111111"; // tài khoản đặt hàng Online.
            $data['hinhthucthanhtoan'] = 'PAYPAL';
            $data['trangthai'] = 2; // trạng thái chờ xác nhận.
            HoaDon::create($data); //tạo hóa đơn.
        } else {
            $iddate = "HD" . Carbon::now('Asia/Ho_Chi_Minh');
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data['id'] = $imp;
            $data['ngaylap'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data['tongtienhoadon'] = Session::get('GioHangOnline')->totalPrice;
            $data['giamgia'] = Session::get('GioHangOnline')->totalDiscount;
            $data['thanhtien'] = Session::get('GioHangOnline')->Total;
            $data['tenkhachhang'] = $request->hoten;
            $data['emailkhachhang'] = $request->email;
            $data['sdtkhachhang'] = $request->sdt;
            $data['diachikhachhang'] = $request->diachi;
            $data['ghichukhachhang'] = $request->ghichu;
            $data['id_khachhang'] = "KH00000000000000";
            $data['id_nhanvien'] = "NV11111111111111"; // tài khoản đặt hàng Online.
            $data['hinhthucthanhtoan'] = 'PAYPAL';
            $data['trangthai'] = 2; // trạng thái chờ xác nhận.
            HoaDon::create($data); //tạo hóa đơn.
        }
        foreach (Session::get('GioHangOnline')->products as $item) { // tạo chi tiết hóa đơn.
            $data2['id_hoadon'] = $imp;
            $data2['id_chitietsanpham'] =  $item['CTSP']->id;
            $data2['soluong'] = $item['SoLuong'];
            $data2['giamgia'] = $item['GiamGia'];
            $data2['tonggia'] = $item['TongGia'];
            ChiTietHoaDon::create($data2); // tạo chi tiết hóa đơn.
        }
        $request->Session()->forget('GioHangOnline'); //xóa session GioHang khi hoàn tất.
        return response()->json(['success' => 'Quý khách đã thành toán pay pal thành công!']);
    }

    public function resultCheckOut()
    {
        // lấy ra sản phẩm "cà phê hạt" đang "bán chạy nhất" với khối lượng "500G".
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $viewData = [
            'CaPheHatBanChayNhat' => SanPham::where('san_pham.the', '=', 'BÁN CHẠY NHẤT')
                ->join('loai_san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
                ->where('loai_san_pham.tenloaisanpham', '=', 'Cà Phê Hạt')  // lấy loại cà phê hạt.
                ->join('chi_tiet_san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->where([
                    ['chi_tiet_san_pham.kichthuoc', '=', '500G'], // lấy sản phẩm có khối lượng 500G.
                    // ['chi_tiet_san_pham.hansudung', '>=', $today], // kiểm tra còn hạng sử dụng hay không.
                ])->select(
                    'san_pham.*',
                    'loai_san_pham.tenloaisanpham',
                    'chi_tiet_san_pham.kichthuoc',
                    'chi_tiet_san_pham.soluong',
                    'chi_tiet_san_pham.giasanpham',
                )->get(),
        ];
        return redirect()->route('Trangchu.index', $viewData)->with('success', 'Thành Công Rồi');
    }
}
