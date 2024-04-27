<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\QuyCach;
use App\Models\LoaiSanPham;
use App\Models\ChiTietSanPham;
use App\http\Requests\SanPhamRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////// index
    public function index() // danh sách.
    {
        $viewData = [
            'SanPham' => SanPham::orderBy('created_at', 'desc')->paginate(10),
            'LoaiSanPham' => LoaiSanPham::all(),
        ];
        return view('backend.SanPham.index', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// create
    public function create() // trang thêm. (chưa ajax)
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::where('trangthai', '!=', 0)->get(),
        ];
        return view('backend.SanPham.create_SanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// store
    public function store(SanPhamRequest $request) // thêm. (chưa ajax)
    {
        // //Validation
        // $request->validate(
        //     [
        //         'tensanpham' => 'required',
        //         'hinhanh' => 'image|max:2048',
        //         'id_loaisanpham' => 'required',
        //     ],
        //     [
        //         'tensanpham.required' => 'Tên Sản Phẩm Không Được Để Trống',

        //         'hinhanh.image' => 'Hãy Chọn Một Tệp Hình Ảnh',
        //         'hinhanh.max' => 'Tệp Hình Ảnh Không Được Lớn Hơn 2MB',

        //         'id_loaisanpham.required' => 'Mã Sản Phẩm Không Được Để Trống',
        //     ]
        // );

        $iddate = "SP" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tensanpham'] = $request->tensanpham;
        $data['mota'] = $request->mota;
        $data['the'] = $request->the;
        $data['id_loaisanpham'] = $request->id_loaisanpham;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        $data['hinhanh'] = 'NOIMAGE.png'; //hình ảnh mặc định.
        if ($request->hasFile('hinhanh')) { //kiểm tra xem có file không.
            $file = $request->hinhanh; //lấy tên hình được gửi lên.
            $extension = $file->extension(); //lấy đui file.
            $path = 'uploads/SanPham/'; //đường dẫn.
            $data['hinhanh'] = $data['id'] . "." . $extension; //sửa lại tên hình ảnh.
            $file->move($path, $data['hinhanh']); //lưu hình ảnh.
        }
        SanPham::create($data);
        $viewData = [
            'SanPham' => SanPham::orderBy('created_at', 'desc')->paginate(10),
            'LoaiSanPham' => LoaiSanPham::all(),
        ];
        return redirect()->route('san-pham.index', $viewData)->with('success', "Thành Công");
    }
    /////////////////////////////////////////////////////////////////////////////////////////// show
    public function show($id) // trang chi tiết.
    {
        $SanPham = SanPham::find($id);
        $LoaiSanPham = LoaiSanPham::where('id', $SanPham->id_loaisanpham)->first();
        $viewData = [
            'SanPham' => $SanPham,
            'QuyCach' => QuyCach::where('id_loaisanpham', $LoaiSanPham->id)->get(),
            'LoaiSanPham' =>  $LoaiSanPham,
            'ChiTietSanPham' => ChiTietSanPham::where('id_sanpham', $SanPham->id)->orderBy('created_at', 'desc')->get(),
        ];
        return view('backend.SanPham.show_SanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// edit
    public function edit($id) // trang cập nhật. (chưa ajax)
    {
        $viewData = [
            'SanPham' => SanPham::find($id),
            'LoaiSanPham' => LoaiSanPham::where('trangthai', '!=', 0)->get(),
        ];
        return view('backend.SanPham.edit_SanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// update
    public function update(SanPhamRequest $request, $id) //cập nhật. (chưa ajax)
    {
        $data['tensanpham'] = $request->tensanpham;
        $data['mota'] = $request->mota;
        $data['the'] = $request->the;
        $data['id_loaisanpham'] = $request->id_loaisanpham;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        if ($request->hasFile('hinhanh')) { //kiểm tra xem có file không.
            $file = $request->hinhanh; //lấy tên hình được gửi lên.
            $extension = $file->extension(); //lấy đui file.
            $path = 'uploads/SanPham/'; //đường dẫn.
            $data['hinhanh'] = $id . "." . $extension; //sửa lại tên hình ảnh.
            $file->move($path, $data['hinhanh']); //lưu hình ảnh.
        }
        SanPham::where('id', $id)->update($data);
        $viewData = [
            'SanPham' => SanPham::orderBy('created_at', 'desc')->paginate(10),
            'LoaiSanPham' => LoaiSanPham::all(),
        ];
        return redirect()->route('san-pham.index', $viewData)->with('success', "Thành Công");
    }
    /////////////////////////////////////////////////////////////////////////////////////////// delete
    public function destroy($id) //xóa.
    {
        $OldSanPham = SanPham::find($id); //lấy sản phẩm củ.
        ChiTietSanPham::where('id_sanpham', $id)->delete();
        SanPham::where('id', $id)->delete();
        if ($OldSanPham->hinhanh != "NOIMAGE.png") { //kiểm tra có phải đang dùng hình ảnh mặc định không.
            unlink('uploads/SanPham/' . $OldSanPham->hinhanh); //xoá ảnh củ.
        }
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// search
    public function search(Request $request) //tìm.
    {
        $loaiSP = LoaiSanPham::where('tenloaisanpham',  $request->search)->first();
        if ($loaiSP == null) {
            $viewData = [
                'SanPham' => SanPham::where('tensanpham', 'like', '%' . $request->search . '%')
                    ->orWhere('the',  $request->search)
                    ->orderBy('created_at', 'desc')->get(),
                'LoaiSanPham' => LoaiSanPham::all(),
            ];
        } else {
            $viewData = [
                'SanPham' => SanPham::where('tensanpham', 'like', '%' . $request->search . '%')
                    ->orWhere('the',  $request->search)
                    ->orWhere('id_loaisanpham',  $loaiSP->id)
                    ->orderBy('created_at', 'desc')->get(),
                'LoaiSanPham' => LoaiSanPham::all(),
            ];
        }
        return view('backend.SanPham.load_SanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// sản phẩm cần xử lý.
    public function handledProductQuantity() //số lượng sản phẩm Cần Xử Lý.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietSanPham = ChiTietSanPham::where('hansudung', '<', $today)->orWhere('soluong', '=', 0)->count();
        echo $ChiTietSanPham;
    }

    public function expiredProductQuantity() //số lượng sản phẩm Hết Hạng.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $ChiTietSanPham = ChiTietSanPham::where('hansudung', '<', $today)->count();
        echo $ChiTietSanPham;
    }

    public function outOfProductQuantity() //số lượng sản phẩm Hết Hạng.
    {
        $ChiTietSanPham = ChiTietSanPham::where('soluong', '=', 0)->count();
        echo $ChiTietSanPham;
    }

    public function expiredProduct() // sản phẩm hết hạng.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        $viewData =  [
            'SanPhamHetHang' => ChiTietSanPham::where('chi_tiet_san_pham.hansudung', '<', $today)
                ->join('san_pham', 'san_pham.id', 'chi_tiet_san_pham.id_sanpham')
                ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.id',
                    'chi_tiet_san_pham.soluong',
                    'chi_tiet_san_pham.ngaysanxuat',
                    'chi_tiet_san_pham.hansudung',
                    'chi_tiet_san_pham.trangthai',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'quy_cach.tenquycach',

                )->paginate(10),
        ];
        return view('backend.SanPham.exprired_SanPham', $viewData);
    }
    public function outOfProduct() // sản phẩm hết hạng.
    {
        $viewData =  [
            'SanPhamHetHang' => ChiTietSanPham::where('chi_tiet_san_pham.soluong', '=', '0')
                ->join('san_pham', 'san_pham.id', 'chi_tiet_san_pham.id_sanpham')
                ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
                ->select(
                    'chi_tiet_san_pham.id',
                    'chi_tiet_san_pham.soluong',
                    'chi_tiet_san_pham.ngaysanxuat',
                    'chi_tiet_san_pham.hansudung',
                    'chi_tiet_san_pham.trangthai',
                    'san_pham.tensanpham',
                    'san_pham.hinhanh',
                    'quy_cach.tenquycach',

                )->paginate(10),
        ];
        return view('backend.SanPham.outof_SanPham', $viewData);
    }

    public function updateHandledProduct(Request $request, $id) //cập nhật chi tiết.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'kichthuoc' => 'required',
                'soluong' => 'required',
                'giasanpham' => 'required',
                'ngaysanxuat' => 'required|date',
                'hansudung' => 'required|date|after:ngaysanxuat',
            ],
            [
                'kichthuoc.required' => 'Quy Cách Không Được Để Trống',

                'soluong.required' => 'Số Lượng Không Được Để Trống',

                'giasanpham.required' => 'Giá Sản Phẩm Không Được Để Trống',

                'ngaysanxuat.required' => 'Ngày Sản Xuất Không Được Để Trống',
                'ngaysanxuat.date' => 'Ngày Sản Xuất Không Đúng Định Dạng Ngày',

                'hansudung.required' => 'Hạn Sử Dụng Không Được Để Trống',
                'hansudung.date' => 'Hạn Sử Dụng Không Đúng Định Dạng Ngày',
                'hansudung.after' => 'Hạn Sử Dụng Phải Sau Ngày Sản Xuất',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        $soluong = filter_var($request->soluong, FILTER_SANITIZE_NUMBER_INT); // tách dấu phẩy và ký tự.
        if ($soluong > 2000000000) { // trả về nếu lớn hơn 2 tỷ.
            return Response()->json(['errors' => 'Số Lượng Phải Nằm Trong Khoảng 0 Đến 2.000.000.000']);
        }
        $giasanpham = filter_var($request->giasanpham, FILTER_SANITIZE_NUMBER_INT); // tách dấu phẩy và ký tự.
        if ($giasanpham > 2000000000) { // trả về nếu lớn hơn 2 tỷ.
            return Response()->json(['errors' => 'Giá Sản Phẩm Phải Nằm Trong Khoảng 0 Đến 2.000.000.000']);
        }

        $data['kichthuoc'] = $request->kichthuoc;
        $data['soluong'] = $soluong;
        $data['giasanpham'] = $giasanpham;
        $data['ngaysanxuat'] = $request->ngaysanxuat;
        $data['hansudung'] = $request->hansudung;
        $data['id_sanpham'] = $request->id_sanpham;
        $data['trangthai'] = $request->trangthai;
        ChiTietSanPham::where('id', $id)->update($data);
        $KTChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', $id)
            ->join('san_pham', 'san_pham.id', 'chi_tiet_san_pham.id_sanpham')
            ->join('quy_cach', 'quy_cach.id', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'chi_tiet_san_pham.id',
                'chi_tiet_san_pham.soluong',
                'chi_tiet_san_pham.ngaysanxuat',
                'chi_tiet_san_pham.hansudung',
                'chi_tiet_san_pham.trangthai',
                'san_pham.tensanpham',
                'san_pham.hinhanh',
                'quy_cach.tenquycach',

            )->first();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        if ($KTChiTietSanPham->hansudung < $today || $KTChiTietSanPham->soluong < 1) {
            $output = "<td><img src='" . asset('uploads/SanPham/' . $KTChiTietSanPham->hinhanh) . "' style='width: 100px; height: 100px; border-radius: 5px;'></td>
            <td>" . $KTChiTietSanPham->tensanpham . "</td>
            <td>" . $KTChiTietSanPham->tenquycach . "</td>
            <td>" . number_format($KTChiTietSanPham->soluong, 0, ',', '.') . "</td>
            <td>" . Date_format(Date_create($KTChiTietSanPham->ngaysanxuat), 'd/m/Y') . "</td>
            <td>" . Date_format(Date_create($KTChiTietSanPham->hansudung), 'd/m/Y') . "</td>
            <td>
                <a href='javascript:(0)' class='action_btn mr_10 view-edit-CTSP' data-url='" . route('chi-tiet-san-pham.edit', $KTChiTietSanPham->id) . "'
                    data-id='" . $KTChiTietSanPham->id . "'>
                    <i class='fas fa-edit'></i></a>
            </td>";
            return $output;
        }
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter
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
        ///////////////////////////////////////// sắp xếp.
        if ($request->sort == 19) {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        ///////////////////////////////////////// loại.
        if ($request->filterloai == 'all0') {
            if ($request->filterthe == 0) {
                $SanPham = SanPham::where('trangthai', '!=', $filtertrangthai)->orderBy('created_at', $sort)->get();
            } elseif ($request->filterthe == 1) {
                $SanPham = SanPham::where([['the', 'THƯỜNG'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
            } elseif ($request->filterthe == 2) {
                $SanPham = SanPham::where([['the', 'MỚI'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
            } else {
                $SanPham = SanPham::where([['the', 'BÁN CHẠY NHẤT'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
            }
            $viewData = [
                'SanPham' => $SanPham,
                'LoaiSanPham' => LoaiSanPham::all(),
            ];
            return view('backend.SanPham.load_SanPham', $viewData);
        }
        if ($request->filterthe == 0) {
            $SanPham = SanPham::where([['id_loaisanpham', $request->filterloai], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
        } elseif ($request->filterthe == 1) {
            $SanPham = SanPham::where([['id_loaisanpham', $request->filterloai], ['the', 'THƯỜNG'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
        } elseif ($request->filterthe == 2) {
            $SanPham = SanPham::where([['id_loaisanpham', $request->filterloai], ['the', 'MỚI'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
        } else {
            $SanPham = SanPham::where([['id_loaisanpham', $request->filterloai], ['the', 'BÁN CHẠY NHẤT'], ['trangthai', '!=', $filtertrangthai]])->orderBy('created_at', $sort)->get();
        }
        $viewData = [
            'SanPham' => $SanPham,
            'LoaiSanPham' => LoaiSanPham::all(),
        ];
        return view('backend.SanPham.load_SanPham', $viewData);
    }
}
