<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\KhachHang;
use App\Models\NhanVien;
use App\Models\ChiTietSanPham;
use App\Models\ChiTietKhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\KhuyenMai;
use App\Models\LoaiSanPham;
use App\Models\ThongKe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;

class HoaDonController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////// gửi email.
    // public function email($id, $TT)
    // {
    //     $HoaDon = HoaDon::find($id);
    //     $viewData = [
    //         'HoaDon' =>  $HoaDon,
    //         'NhanVien' => NhanVien::where('id', $HoaDon->id_nhanvien)->first(),
    //         'KhachHang' => KhachHang::where('id', $HoaDon->id_khachhang)->first(),

    //         'ChiTietHoaDon' => ChiTietHoaDon::where('chi_tiet_hoa_don.id_hoadon', $id)
    //             ->join('chi_tiet_san_pham', 'chi_tiet_san_pham.id', '=', 'chi_tiet_hoa_don.id_chitietsanpham')
    //             ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
    //             ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
    //             ->select(
    //                 'chi_tiet_hoa_don.*',
    //                 'chi_tiet_san_pham.giasanpham',
    //                 'quy_cach.tenquycach',
    //                 'san_pham.tensanpham',
    //             )
    //             ->get(),
    //     ];
    //     if ($TT == 1) {
    //         return view('backend.Email.send_email', $viewData);
    //     } else {
    //         return view('backend.Email.send_email_cancel', $viewData);
    //     }
    // }
    public function send_email($id, $TT)
    {
        $HoaDon = HoaDon::find($id);
        $to_name = "Bling Coffee";
        $to_email = $HoaDon->emailkhachhang;
        $viewData = [
            'HoaDon' =>  $HoaDon,
            'NhanVien' => NhanVien::where('id', $HoaDon->id_nhanvien)->first(),
            'KhachHang' => KhachHang::where('id', $HoaDon->id_khachhang)->first(),

            'ChiTietHoaDon' => ChiTietHoaDon::where('chi_tiet_hoa_don.id_hoadon', $id)
                ->join('chi_tiet_san_pham', 'chi_tiet_san_pham.id', '=', 'chi_tiet_hoa_don.id_chitietsanpham')
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->select(
                    'chi_tiet_hoa_don.*',
                    'chi_tiet_san_pham.giasanpham',
                    'quy_cach.tenquycach',
                    'san_pham.tensanpham',
                )
                ->get(),
        ];
        if ($TT == 1) {
            Mail::send('backend.Email.send_email', $viewData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Báo Đã Xác Nhận Đơn Hàng');
                $message->from($to_email, $to_name);
            });
        } else {
            Mail::send('backend.Email.send_email_cancel', $viewData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Báo Đơn Hàng Của Bạn Bị Hủy');
                $message->from($to_email, $to_name);
            });
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////// in hóa đơn.
    public function print_bill($id) // xem trước khi in.
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($id));
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
    }
    // public function download_bill($id) // tải file.
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->loadHTML($this->print_order_convert($id));
    //     // return $pdf->stream();
    //     return $pdf->download('invoice.pdf');
    // }
    public function print_order_convert($id) // in hóa đơn.
    {
        $HoaDon = HoaDon::find($id);
        $NhanVien = NhanVien::where('id', $HoaDon->id_nhanvien)->first();

        $ChiTietHoaDon = ChiTietHoaDon::where('chi_tiet_hoa_don.id_hoadon', $id)
            ->join('chi_tiet_san_pham', 'chi_tiet_san_pham.id', '=', 'chi_tiet_hoa_don.id_chitietsanpham')
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->select(
                'chi_tiet_hoa_don.*',
                'chi_tiet_san_pham.giasanpham',
                'quy_cach.tenquycach',
                'san_pham.tensanpham',
            )
            ->get();
        $output = "
        <style>
        body {text-align: center;margin: 10px;font-family: 'Times New Roman';}
        .main_title {font-size: 35px;margin-bottom: 10px;}
        .address {font-size: 20px;margin: 0px;}
        .bill {font-size: 35px;margin: 0px 0px;}
        th,td {padding: 10px 0px 0px 0px;text-align: left;font-size: 20px;}
        .table {width: 100%;}
        .table th,.table td {text-align: right;}
        .table tbody tr th {font-size: 20px;}
        .table th,.table td {text-align: right;}
        .total {width: 100%;}
        .total td {text-align: right;font-size: 21px;}
        .money td {font-weight: bolder;}
        h3.contact {margin: 0;font-size: 20px;}
        h3.contact-top{margin-top: 35px;}
        hr.new2 {border-top: 3px dashed gray;border-bottom: none;}
        </style>
        <h1 class='main_title'>Bling Coffee</h1>
        <h1 class='address'>184 Lê Đại Hành, phường 15, quận 11, TPHCM</h1>
        <hr>
        <h1 class='bill'>PHIẾU THANH TOÁN</h1>
        <table>
            <tbody>
                <tr>
                    <td>
                        Mã HD:
                    </td>
                    <td>
                      " . $id . "
                    </td>
                </tr>
                <tr>
                    <td>
                        Ngày lập:
                    </td>
                    <td>
                       " . Date_format(Date_create($HoaDon->ngaylap), 'd/m/Y H:i:s') . "
                    </td>
                </tr>
                    <tr>
                        <td>
                            Nhân viên:
                        </td>
                        <td>
                        " . $NhanVien->tennhanvien . "
                        </td>
                    </tr>
            </tbody>
        </table>
        <hr class='new2'>
        <table class='table'>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Giảm Giá</th>
                    <th>Giá bán</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($ChiTietHoaDon as $HD) {

            if ($HD->giamgia != 0) { // nếu có giảm giá.
                $GG = number_format(($HD->giamgia), 0, ',', '.');
            } else { // không có giảm giá.
                $GG =  "";
            }

            $output .= "<tr>
                        <th style='text-align: left;text-transform: uppercase;' colspan='4'>" . $HD->tensanpham . " " . $HD->tenquycach . "</th>
                    </tr>
                    <tr>
                        <td>" . number_format($HD->soluong, 0, ',', '.') . "</td>
                        <td>" . $GG . "</td>
                        <td>" . number_format($HD->giasanpham, 0, ',', '.') . "</td>
                        <td>" . number_format($HD->tonggia, 0, ',', '.') . "</td>
                    </tr>";
        }
        $output .= "</tbody>
        </table>
        <hr class='new2'>
        <table class='total'>
            <tbody>
                <tr>
                    <td>
                        Tổng tiền:
                    </td>
                    <td>
                    " . number_format($HoaDon->tongtienhoadon, 0, ',', '.') . "
                    </td>
                </tr>";

        /////////////////////////////////////////////////////////////////////////////////////////// kiểm tra có giảm giá hay không.
        if ($HoaDon->giamgia != 0) {
            $output .= "<tr>
                    <td>
                        Đã giảm:
                    </td>
                    <td>
                    " . number_format($HoaDon->giamgia, 0, ',', '.') . "
                    </td>
                </tr>";
        }
        /////////////////////////////////////////////////////////////////////////////////////////// kiểm tra có giảm giá thành viên không.
        $thanhvien = $HoaDon->tongtienhoadon - $HoaDon->giamgia - $HoaDon->thanhtien;
        if ($thanhvien != 0) {
            $output .= "<tr>
                    <td>
                        Giảm giá thành viên:
                    </td>
                    <td>
                    " . number_format($thanhvien, 0, ',', '.') . "
                    </td>
                </tr>";
        }
        $output .= "<tr class='money'>
                    <td>
                        Thanh toán:
                    </td>
                    <td>
                    " . number_format($HoaDon->thanhtien, 0, ',', '.') . "
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h3 class='contact contact-top'>Thông tin liên lạc: +84343344659</h3>
        <h3 class='contact'>Email: blingcoffee@gmail.com</h3>";

        return $output;
    }
    /////////////////////////////////////////////////////////////////////////////////////////// danh sách hóa đơn.
    public function index() //danh sách hóa đơn.
    {
        $viewData = [
            'HoaDon' => HoaDon::where([['trangthai', '!=', '2'], ['trangthai', '!=', '3']])->orderBy('created_at', 'desc')->paginate(10),
            'NhanVien' => NhanVien::all(),
        ];
        return view('backend.HoaDon.index', $viewData);
    }
    public function show($id) //hiện chi tiết hóa đơn.
    {
        $HoaDon = HoaDon::find($id);
        $viewData = [
            'HoaDon' => $HoaDon,
            'NhanVien' => NhanVien::where('id', $HoaDon->id_nhanvien)->first(),
            'ChiTietHoaDon' => ChiTietHoaDon::where('id_hoadon', $id)->get(),
            'ChiTietSanPham' => ChiTietSanPham::join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.*',
                    'quy_cach.tenquycach',
                )->get(),
            'SanPham' => SanPham::all(),
        ];
        return view('backend.HoaDon.show_HoaDon', $viewData);
    }
    public function updateStatus(Request $request, $id)
    {
        $HoaDon = HoaDon::find($id);
        $KhachHang = KhachHang::find($HoaDon->id_khachhang);
        $NhanVien = NhanVien::find($HoaDon->id_nhanvien);
        if ($HoaDon->trangthai == 1) {
            $data['trangthai'] = 0;
        } elseif ($HoaDon->trangthai == 2) {
            $data['trangthai'] = 1;
        } else {
            $data['trangthai'] = 1;
        }
        HoaDon::where('id', $id)->update($data);
        if ($data['trangthai'] == 1) {
            $trangthai =  "<span class='badge bg-success'>Hoàn Thành</span>";
        } else {
            $trangthai =  "<span class='badge bg-danger'>Đã Đóng</span>";
        }
        $output = "
        <td style='text-align: left'>" . Date_format(Date_create($HoaDon->ngaylap), 'd/m/Y H:i:s') . "</td>
        <td>" . $HoaDon->sdtkhachhang . "</td>
        <td>" . $KhachHang->tenkhachhang . "</td>
        <td>" . $NhanVien->tennhanvien . "</td>
        <td>" . $trangthai . "
        </td>
        <td>
        <a data-id='" . $HoaDon->id . "' href='javascript:(0)' class='action_btn mr_10 view-show'> <i class='fas fa-eye'></i></a>
        <a data-id='" . $HoaDon->id . "' href='javascript:(0)' class='action_btn mr_10 form-updatestatus'> <i class='fas fa-pencil-alt'></i></a>
        <a data-id='" . $HoaDon->id . "' href='javascript:(0)' class='action_btn form-delete'> <i class='fas fa-trash-alt'></i></a>
        </td>";
        echo $output;
    }
    public function destroy($id) //xóa.
    {
        $data['trangthai'] = 3;
        HoaDon::where('id', $id)->update($data);
    }
    public function search(Request $request) //tìm.
    {
        if ($request->search != "Khách Vãng Lai") {
            // tên khách hàng, sdt người lập(chính xác), sdt khách hàng
            $NhanVien = NhanVien::where('sdt',  $request->search)->first();
            if ($NhanVien == null) {
                $id_NhanVien = "1";
            } else {
                $id_NhanVien = $NhanVien->id;
            }
            $HoaDon = HoaDon::where([['trangthai', '!=', '2'], ['trangthai', '!=', '3'], ['tenkhachhang', 'like', '%' . $request->search . '%']])
                ->orwhere([['trangthai', '!=', '2'], ['trangthai', '!=', '3'], ['sdtkhachhang', 'like', '%' . $request->search . '%']])
                ->orwhere([['trangthai', '!=', '2'], ['trangthai', '!=', '3'], ['id_nhanvien', $id_NhanVien]])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $HoaDon = HoaDon::where([['trangthai', '!=', '2'], ['trangthai', '!=', '3'], ['id_khachhang', 'KH00000000000000']])->orderBy('created_at', 'desc')->get();
        }
        $output = "";
        if (Auth::user()->id_loainhanvien == 'LNV00000000000000') {
            foreach ($HoaDon as $value) {
                $NhanVien = NhanVien::find($value->id_nhanvien);
                if ($value->trangthai == 1) {
                    $trangthai =  "<span class='badge bg-success'>Hoàn Thành</span>";
                } else {
                    $trangthai =  "<span class='badge bg-danger'>Đã Đóng</span>";
                }
                $output .= "<tr id=" . $value->id . ">
                <td style='text-align: left'>" . $value->ngaylap . "</td>
                <td>" . $value->sdtkhachhang . "</td>
                <td>" . $value->tenkhachhang . "</td>
                <td>" . $NhanVien->tennhanvien . "</td>
                <td>" . $trangthai . " </td>
                <td>
                <a data-id='" . $value->id . "' href='javascript:(0)' class='action_btn mr_10 view-show'> <i class='fas fa-eye'></i></a>
                <a data-id='" . $value->id . "' href='javascript:(0)' class='action_btn mr_10 form-updatestatus'> <i class='fas fa-pencil-alt'></i></a>
                <a data-id='" . $value->id . "' href='javascript:(0)' class='action_btn form-delete'> <i class='fas fa-trash-alt'></i></a>
                </td> </tr>";
            }
        } else {
            foreach ($HoaDon as $value) {
                $NhanVien = NhanVien::find($value->id_nhanvien);
                if ($value->trangthai == 1) {
                    $trangthai =  "<span class='badge bg-success'>Hoàn Thành</span>";
                } else {
                    $trangthai =  "<span class='badge bg-danger'>Đã Đóng</span>";
                }
                $output .= "<tr id=" . $value->id . ">
                <td style='text-align: left'>" . $value->ngaylap . "</td>
                <td>" . $value->sdtkhachhang . "</td>
                <td>" . $value->tenkhachhang . "</td>
                <td>" . $NhanVien->tennhanvien . "</td>
                <td>" . $trangthai . " </td>
                <td>
                <a data-id='" . $value->id . "' href='javascript:(0)' class='action_btn mr_10 view-show'> <i class='fas fa-eye'></i></a>
                </td> </tr>";
            }
        }
        echo $output;
    }
    /////////////////////////////////////////////////////////////////////////////////////////// Thêm giỏ hàng
    public function create() // đến trang thêm sản phẩm vào giỏ hàng.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $viewData = [
            'SanPham' => SanPham::where('trangthai', 1)->orderBy('created_at', 'desc')->get(),
            'ChiTietSanPham' => ChiTietSanPham::where([['chi_tiet_san_pham.hansudung', '>=', $today], ['chi_tiet_san_pham.soluong', '>', 0], ['chi_tiet_san_pham.trangthai', 1]])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.*',
                    'quy_cach.tenquycach',
                )->get(),
            'LoaiSanPham' => LoaiSanPham::where('trangthai', '!=', 0)->orderBy('created_at', 'desc')->get(),
        ];
        return view('backend.HoaDon.create_HoaDon', $viewData);
    }
    public function priceProduct($id) //lấy giá sản phẩm
    {
        $ChiTietSanPham = ChiTietSanPham::find($id);
        $output = "" . number_format($ChiTietSanPham->giasanpham, 0, ',', '.') . " VNĐ";
        echo $output;
    }
    public function discountProduct($id) //lấy giảm giá của sản phẩm.
    {
        $ChiTietSanPham = ChiTietSanPham::find($id); // lấy giá sản phẩm.
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietKhuyenMai = ChiTietKhuyenMai::where('id_chitietsanpham', $id)
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
        if ($ChiTietKhuyenMai != null) {
            $discount = ($ChiTietSanPham->giasanpham * ($ChiTietKhuyenMai->muckhuyenmai / 100));
            $output = "-" . number_format($discount, 0, ',', '.') . " VNĐ";
            echo $output;
        } else {
            $output = "";
            echo $output;
        }
    }
    public function addCart(Request $request, $id) // thêm sản phẩm vào giỏ hàng.
    {
        $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $id)
            ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'chi_tiet_san_pham.*',
                'quy_cach.tenquycach',
            )->first();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietKhuyenMai = ChiTietKhuyenMai::where('id_chitietsanpham', $id)
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
        if ($ChiTietSanPham != null) {
            $SanPham = SanPham::where('id', $ChiTietSanPham->id_sanpham)->first();
            $odlCart = Session('GioHang') ? Session('GioHang') : null;
            $newCart = new Cart($odlCart);
            if ($ChiTietKhuyenMai != null) {
                $newCart->addCart($id, $SanPham, $ChiTietSanPham, $ChiTietKhuyenMai->muckhuyenmai);
            } else {
                $newCart->addCart($id, $SanPham, $ChiTietSanPham, 0);
            }
            $request->Session()->put('GioHang', $newCart);
            return view('backend.HoaDon.createItem_hoa_don');
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////// cập nhật giỏ hàng
    public function quantityChange(Request $request) // thai đổi số lượng sản phẩm trong giỏ hàng.
    {
        foreach ($request->data as $item) {
            $odlCart = Session('GioHang') ? Session('GioHang') : null;
            $newCart = new Cart($odlCart);
            $newCart->quantityChange($item['id'], $item['sl']);
            $request->session()->put('GioHang', $newCart);
        }
        return view('backend.HoaDon.createItem_hoa_don');
    }
    /////////////////////////////////////////////////////////////////////////////////////////// xóa giỏ hàng
    public function deleteItemHoaDon(Request $request, $id) // xóa sản phẩm khỏi hóa đơn.
    {
        $odlCart = Session('GioHang') ? Session('GioHang') : null;
        $newCart = new Cart($odlCart);
        $newCart->deleteItemCart($id);
        if (count($newCart->products) > 0) {
            $request->session()->put('GioHang', $newCart);
        } else {
            $request->Session()->forget('GioHang');
        }
        return view('backend.HoaDon.createItem_hoa_don');
    }
    public function deleteHoaDon(Request $request) // xóa sản phẩm khỏi hóa đơn.
    {
        $request->Session()->forget('GioHang');
        return view('backend.HoaDon.createItem_hoa_don');
    }
    /////////////////////////////////////////////////////////////////////////////////////////// tìm kiếm
    public function searchProduct(Request $request) //tìm sản phẩm.
    {
        $keyword = $request->keyword;
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $viewData = [
            'SanPham' => SanPham::where([
                ['tensanpham', 'like', '%' . $keyword . '%'],
                ['trangthai', 1],
            ])->orderBy('created_at', 'desc')->get(),
            'ChiTietSanPham' => ChiTietSanPham::where([['chi_tiet_san_pham.hansudung', '>=', $today], ['chi_tiet_san_pham.soluong', '>', 0], ['chi_tiet_san_pham.trangthai', 1]])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.*',
                    'quy_cach.tenquycach',
                )->get(),
        ];
        return view('backend.HoaDon.searchProduct_hoa_don', $viewData);
    }
    public function searchCustomer(Request $request) //tìm khách hàng.
    {
        $sdt = $request->sdt;
        // $KhachMuaHang = KhachHang::where('sdt', $sdt)->first();
        $viewData = [
            'KhachMuaHang' => KhachHang::where('sdt', $sdt)->first(),
        ];
        return view('backend.HoaDon.searchMember_hoa_don', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// khách mua hàng
    public function discountMember(Request $request) // áp dụng giảm giá cho thành viên.
    {
        $sdt = $request->sdt;
        $KhachMuaHang = KhachHang::where([['sdt', $sdt], ['trangthai', 1]])->first();
        $odlCart = Session('GioHang') ? Session('GioHang') : null;
        $newCart = new Cart($odlCart);
        $newCart->DiscountMember($KhachMuaHang->diemtichluy, $KhachMuaHang->sdt);
        $request->session()->put('GioHang', $newCart);
        return view('backend.HoaDon.createItem_hoa_don');
    }
    public function unDiscountMember(Request $request) // bỏ áp dụng giảm giá cho thành viên.
    {
        $odlCart = Session('GioHang') ? Session('GioHang') : null;
        $newCart = new Cart($odlCart);
        $newCart->DiscountMember(0, null);
        $request->session()->put('GioHang', $newCart);
        return view('backend.HoaDon.createItem_hoa_don');
    }
    /////////////////////////////////////////////////////////////////////////////////////////// in hóa đơn
    public function in(Request $request) // tạo hóa đơn và chi tiết hóa đơn. (chưa in hóa đơn)
    {
        $iddate = "HD" . Carbon::now('Asia/Ho_Chi_Minh'); //tạo hóa đơn.
        $exp = explode("-", $iddate);
        $imp = implode('', $exp);
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['ngaylap'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['tongtienhoadon'] = Session::get('GioHang')->totalPrice;
        $data['giamgia'] = Session::get('GioHang')->totalDiscount;
        $data['thanhtien'] = Session::get('GioHang')->Total;
        if (Session::get('GioHang')->PhoneMember != null) { //khi khách mua hàng là thành viên.
            $KhachMuaHang = KhachHang::where('sdt', Session::get('GioHang')->PhoneMember)->first();
            $data['tenkhachhang'] = $KhachMuaHang->tenkhachhang;
            $data['sdtkhachhang'] = $KhachMuaHang->sdt;
            $data['diachikhachhang'] = $KhachMuaHang->diachi;
            $data['emailkhachhang'] = $KhachMuaHang->email;
            $data['id_khachhang'] = $KhachMuaHang->id;
            $data['diemtichluy'] = Session::get('GioHang')->Total / 10000;
            $diemtichluy = $KhachMuaHang->diemtichluy + $data['diemtichluy']; // tích lũy điểm mua hàng.
            KhachHang::where("id", $KhachMuaHang->id)->update(['diemtichluy' => $diemtichluy]);
        } else { //khi khách mua hàng không phải là thành viên.
            $data['id_khachhang'] = "KH00000000000000";
            $data['tenkhachhang'] = "Khách Vãng Lai";
        }
        $data['id_nhanvien'] = Auth::id(); //lấy id nhân viên đã đăng nhập.
        $data['trangthai'] = 1;
        HoaDon::create($data);
        /////////////////////////////////////////////////////////////////////////////////////////// chi tiết hóa đơn.
        foreach (Session::get('GioHang')->products as $item) { // tạo chi tiết hóa đơn.
            $data2['id_hoadon'] = $imp;
            $data2['id_chitietsanpham'] =  $item['CTSP']->id;
            $data2['soluong'] = $item['SoLuong'];
            $data2['giamgia'] = $item['GiamGia'];
            $data2['tonggia'] = $item['TongGia'];
            ChiTietHoaDon::create($data2);
            /////////////////////////////////////////////////////////////////////////////////////// cập nhật lại số lượng.
            $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $item['CTSP']->id)
                ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
                ->join('loai_san_pham', 'san_pham.id_loaisanpham', '=', 'loai_san_pham.id')
                ->select(
                    'chi_tiet_san_pham.soluong',
                    'loai_san_pham.trangthai',
                )->first(); // cập nhật số lượng còn lại.
            if ($ChiTietSanPham->trangthai == 1) {
                $data3['soluong'] = $ChiTietSanPham->soluong - $item['SoLuong'];
                ChiTietSanPham::where('id', $item['CTSP']->id)->update($data3);
            }
        }
        /////////////////////////////////////////////////////////////////////////////////////////// tính thống kê.
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ThongKe = ThongKe::where('thoigian', $today)->first();
        if ($ThongKe != null) {
            $data4['doanhso'] = $ThongKe->doanhso + Session::get('GioHang')->Total;
            $data4['loinhuan'] = $ThongKe->loinhuan + (Session::get('GioHang')->totalPrice * 0.4);
            $data4['soluongdaban'] = $ThongKe->soluongdaban + Session::get('GioHang')->totalQuanty;
            $data4['soluongdonhang'] = $ThongKe->soluongdonhang + 1;
            ThongKe::where('thoigian', $today)->update($data4);
        } else {
            $iddate = "TK" . Carbon::now('Asia/Ho_Chi_Minh'); //tạo hóa đơn.
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data4['id'] = $imp;
            $data4['thoigian'] = $today;
            $data4['doanhso'] = Session::get('GioHang')->Total;
            $data4['loinhuan'] = (Session::get('GioHang')->totalPrice * 0.4);
            $data4['soluongdaban'] = Session::get('GioHang')->totalQuanty;
            $data4['soluongdonhang'] = 1;
            ThongKe::create($data4);
        }
        $request->Session()->forget('GioHang'); //xóa session GioHang khi hoàn tất.
        return redirect()->route('hoa-don.index')->with('success', $data['id']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// xác nhận hóa đơn.
    public function  handleDelivery() // trang xác nhận hóa đơn.
    {
        $viewData = [
            'HoaDon' => HoaDon::where('trangthai', 2)->orderBy('created_at', 'asc')->paginate(10),
            'KhachHang' => KhachHang::all(),
        ];
        return view('backend.HoaDon.handleDelivery', $viewData);
    }

    public function countHandleDelivery() // lấy số lượng hóa đơn cần được xác nhận.
    {
        $HoaDon = HoaDon::where('trangthai', 2)->count();
        echo $HoaDon;
    }

    public function updateDelivery(Request $request, $id) // xác nhận hóa đơn, cộng điểm tích lũy, cập nhật số lượng sản phẩm {xử lý gửi email, in hóa đơn khi trang thái = 2}
    {
        $HoaDon = HoaDon::find($id);
        /////////////////////////////////////////////////////////////////////////////////////////// cập nhật số lượng sản phẩm.
        $ChiTietHoaDon = ChiTietHoaDon::where('id_hoadon', $HoaDon->id)->get();
        $success = 1;
        $error = "";
        foreach ($ChiTietHoaDon as $item) {
            $ChiTietSanPham = ChiTietSanPham::where('id', $item->id_chitietsanpham)->first(); // lấy ra số lượng củ.
            $SanPham = SanPham::where('id', $ChiTietSanPham->id_sanpham)->first(); // lấy ra tên.
            $data3['soluong'] = $ChiTietSanPham->soluong - $item->soluong; // tính lại số lượng.
            if ($data3['soluong'] < 0) {
                $error .= $SanPham->tensanpham . " (" . $ChiTietSanPham->kichthuoc . ") Không đủ " . $item->soluong . " sản phẩm<br><br>";
                $success = 0;
            }
        }
        if ($success == 0) {
            return response()->json(['errors' => $error]); // trả về nếu không đủ số lượng.
        }
        $SLSP = 0; // dùng để tính thống kê.
        foreach ($ChiTietHoaDon as $item) {
            $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $item->id_chitietsanpham)->first(); // cập nhật số lượng còn lại.
            if ($ChiTietSanPham->trangthai == 1) {
                $data3['soluong'] = $ChiTietSanPham->soluong - $item->soluong;
                ChiTietSanPham::where('id', $item->id_chitietsanpham)->update($data3);
            }
            $SLSP += $item->soluong;
        }
        /////////////////////////////////////////////////////////////////////////////////////////// cập nhật điểm tích lũy.
        $KhachHang = KhachHang::find($HoaDon->id_khachhang);
        $diemtichluy = $KhachHang->diemtichluy + $HoaDon->diemtichluy;
        KhachHang::where("id", $KhachHang->id)->update(['diemtichluy' => $diemtichluy]); // cập nhật điểm tích lũy.
        /////////////////////////////////////////////////////////////////////////////////////////// tính thống kê.
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ThongKe = ThongKe::where('thoigian', $today)->first();
        if ($ThongKe != null) {
            $data4['doanhso'] = $ThongKe->doanhso + $HoaDon->thanhtien;
            $data4['loinhuan'] = $ThongKe->loinhuan + ($HoaDon->tongtienhoadon * 0.4);
            $data4['soluongdaban'] = $ThongKe->soluongdaban + $SLSP;
            $data4['soluongdonhang'] = $ThongKe->soluongdonhang + 1;
            ThongKe::where('thoigian', $today)->update($data4);
        } else {
            $iddate = "TK" . Carbon::now('Asia/Ho_Chi_Minh'); //tạo hóa đơn.
            $exp = explode("-", $iddate);
            $imp = implode('', $exp);
            $exp = explode(" ", $imp);
            $imp = implode('', $exp);
            $exp = explode(":", $imp);
            $imp = implode('', $exp);
            $data4['id'] = $imp;
            $data4['thoigian'] = $today;
            $data4['doanhso'] = $HoaDon->thanhtien;
            $data4['loinhuan'] = ($HoaDon->tongtienhoadon * 0.4);
            $data4['soluongdaban'] = $SLSP;
            $data4['soluongdonhang'] = 1;
            ThongKe::create($data4);
        }
        /////////////////////////////////////////////////////////////////////////////////////////// cập nhật trạng thái.
        if ($HoaDon->trangthai == 1) {
            $data['trangthai'] = 0;
        } elseif ($HoaDon->trangthai == 2) {
            $data['trangthai'] = 1;
        } else {
            $data['trangthai'] = 1;
        }
        HoaDon::where('id', $id)->update($data);
        if ($data['trangthai'] == 1) {
            $trangthai =  "<span class='badge bg-success'>Hoàn Thành</span>";
        } else {
            $trangthai =  "<span class='badge bg-danger'>Đã Đóng</span>";
        }
        if ($HoaDon->hinhthucthanhtoan != null) {
            $hinhthucthanhtoan =  "<span class='badge bg-success'> Qua " . $HoaDon->hinhthucthanhtoan . "</span>";
        } else {
            $hinhthucthanhtoan =  "<span class='badge bg-warning'>Khi Nhận Hàng</span>";
        }
        $output = "
            <td style='text-align: left'>" . Date_format(Date_create($HoaDon->thoigian), 'd/m/Y H:i:s')  . "</td>
            <td>" . $HoaDon->sdtkhachhang . "</td>
            <td>" . $HoaDon->tenkhachhang . "</td>
            <td>" . $hinhthucthanhtoan . "</td>
            <td>" . $trangthai . "
            </td>
            <td>
            <a data-id='" . $HoaDon->id . "' href='javascript:(0)' class='action_btn mr_10 view-show'> <i class='fas fa-eye'></i></a>
            </td>";
        echo $output;
    }

    public function deleteDelivery($id) //xóa xác nhận.
    {
        $data['trangthai'] = 3;
        HoaDon::where('id', $id)->update($data);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter.
    public function filter(Request $request) //tìm.
    {
        ///////////////////////////////////////// trạng thái.
        if ($request->filtertrangthai == 'on') {
            $filtertrangthai = 0;
        } elseif ($request->filtertrangthai == 'off') {
            $filtertrangthai = 1;
        } else {
            $filtertrangthai = 9;
        }
        ///////////////////////////////////////// ngày.
        if ($request->filterngay != null) {
            if ($request->sort == 19) {
                $HoaDon = HoaDon::where([['ngaylap', 'like',  $request->filterngay . '%'], ['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('created_at', 'desc')->get();
            } elseif ($request->sort == 29) {
                $HoaDon = HoaDon::where([['ngaylap', 'like',  $request->filterngay . '%'], ['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('created_at', 'asc')->get();
            } elseif ($request->sort == 39) {
                $HoaDon = HoaDon::where([['ngaylap', 'like',  $request->filterngay . '%'], ['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('trangthai', 'desc')->get();
            } else {
                $HoaDon = HoaDon::where([['ngaylap', 'like',  $request->filterngay . '%'], ['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('trangthai', 'asc')->get();
            }
        } else {
            if ($request->sort == 19) {
                $HoaDon = HoaDon::where([['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('created_at', 'desc')->get();
            } elseif ($request->sort == 29) {
                $HoaDon = HoaDon::where([['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('created_at', 'asc')->get();
            } elseif ($request->sort == 39) {
                $HoaDon = HoaDon::where([['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('trangthai', 'desc')->get();
            } else {
                $HoaDon = HoaDon::where([['trangthai', '!=', $filtertrangthai], ['trangthai', '!=', '3'], ['trangthai', '!=', '2']])
                    ->orderBy('trangthai', 'asc')->get();
            }
        }

        $viewData = [
            'HoaDon' => $HoaDon,
            'NhanVien' => NhanVien::all(),
        ];
        return view('backend.HoaDon.load_HoaDon', $viewData);
    }
    public function  filterProduct(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        if ($request->filterloai == 'all') {
            $SanPham =  SanPham::where('trangthai', 1)->orderBy('created_at', 'desc')->get();
        } else {
            $SanPham =  SanPham::where([
                ['id_loaisanpham', $request->filterloai],
                ['trangthai', 1],
            ])->orderBy('created_at', 'desc')->get();
        }
        $viewData = [
            'SanPham' => $SanPham,
            'ChiTietSanPham' => ChiTietSanPham::where([['chi_tiet_san_pham.hansudung', '>=', $today], ['chi_tiet_san_pham.soluong', '>', 0], ['chi_tiet_san_pham.trangthai', 1]])
                ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.*',
                    'quy_cach.tenquycach',
                )->get(),
        ];
        return view('backend.HoaDon.searchProduct_hoa_don', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// Hóa Đơn Đã Hủy.
    public function cancelled() // ds đã hủy
    {
        $viewData = [
            'HoaDon' => HoaDon::where('trangthai', '3')->orderBy('created_at', 'desc')->paginate(10),
            'NhanVien' => NhanVien::all(),
        ];
        return view('backend.HoaDon.cancelled', $viewData);
    }
    public function searchCancelled(Request $request) //tìm.
    {
        if ($request->search != "Khách Vãng Lai") {
            // tên khách hàng, sdt người lập(chính xác), sdt khách hàng
            $NhanVien = NhanVien::where('sdt',  $request->search)->first();
            if ($NhanVien == null) {
                $id_NhanVien = "1";
            } else {
                $id_NhanVien = $NhanVien->id;
            }
            $HoaDon = HoaDon::where([['trangthai', '3'], ['tenkhachhang', 'like', '%' . $request->search . '%']])
                ->orwhere([['trangthai', '3'], ['sdtkhachhang', 'like', '%' . $request->search . '%']])
                ->orwhere([['trangthai', '3'], ['id_nhanvien', $id_NhanVien]])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $HoaDon = HoaDon::where([['trangthai', '3'], ['id_khachhang', 'KH00000000000000']])->orderBy('created_at', 'desc')->get();
        }
        $output = "";
        foreach ($HoaDon as $value) {
            $NhanVien = NhanVien::find($value->id_nhanvien);
            $output .= "<tr id=" . $value->id . ">
            <td style='text-align: left'>" . $value->ngaylap . "</td>
            <td>" . $value->sdtkhachhang . "</td>
            <td>" . $value->tenkhachhang . "</td>
            <td>" . $NhanVien->tennhanvien . "</td>
            <td><span class='badge bg-warning'>Đã Hủy</span> </td>
            <td>
            <a data-id='" . $value->id . "' href='javascript:(0)' class='action_btn mr_10 view-show'> <i class='fas fa-eye'></i></a>
            </td> </tr>";
        }
        echo $output;
    }
}
