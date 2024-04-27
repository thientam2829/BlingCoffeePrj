<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\LoaiNhanVien;
use App\http\Requests\NhanVienRequest;
use App\Models\ChiTietSanPham;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NhanVienController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////// index
    public function index() //danh sách.
    {
        $viewData = [
            'NhanVien' => NhanVien::where(
                [
                    ['id', '!=', "NV00000000000000"], //admin
                    ['id', '!=', "NV11111111111111"] //online
                ]
            )->orderBy('created_at', 'desc')->paginate(10),
            'LoaiNhanVien' => LoaiNhanVien::where(
                [
                    ['id', '!=', "LNV00000000000000"], //admin
                ]
            )->get(),
        ];
        return view('backend.NhanVien.index', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// create
    public function create() // trang thêm. (chưa ajax)
    {
        $viewData = [
            'LoaiNhanVien' => LoaiNhanVien::where([['id', '!=', "LNV00000000000000"], ['trangthai', 1]])->get(),
        ];
        return view('backend.NhanVien.create_NhanVien', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// store
    public function store(NhanVienRequest $request) //thêm. (chưa ajax)
    {
        $luong = filter_var($request->luong, FILTER_SANITIZE_NUMBER_INT); // tách dấu phẩy và ký tự.
        if ($luong > 2000000000) { // trả về nếu lớn hơn 2 tỷ.
            return Response()->json(['errors' => 'Lương Phải Nằm Trong Khoảng 0 Đến 2.000.000.000']);
        }

        $iddate = "NV" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tennhanvien'] = $request->tennhanvien;
        $data['sdt'] = $request->sdt;
        $data['diachi'] = $request->diachi;
        $data['ngaysinh'] = $request->ngaysinh;
        $data['gioitinh'] = $request->gioitinh;
        $data['luong'] = $luong;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['id_loainhanvien'] = $request->id_loainhanvien;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        $data['hinhanh'] = 'NOIMAGE.png'; //hình ảnh mặc định.
        if ($request->hasFile('hinhanh')) { //kiểm tra xem có file không.
            $file = $request->hinhanh; //lấy tên hình được gửi lên.
            $extension = $file->extension(); //lấy đui file.
            $path = 'uploads/NhanVien/'; //đường dẫn.
            $data['hinhanh'] = $data['id'] . "." . $extension; //sửa lại tên hình ảnh.
            $file->move($path, $data['hinhanh']); //lưu hình ảnh.
        }
        NhanVien::create($data);
        $viewData = [
            'NhanVien' => NhanVien::orderBy('created_at', 'desc')->get(),
            'LoaiNhanVien' => LoaiNhanVien::all(),
        ];
        return redirect()->route('nhan-vien.index', $viewData)->with('success', "Thành Công");
    }
    /////////////////////////////////////////////////////////////////////////////////////////// show
    public function show($id) //cho tiết.
    {
        $viewData = [
            'NhanVien' => NhanVien::find($id),
            'LoaiNhanVien' => LoaiNhanVien::all(),
        ];
        return view('backend.NhanVien.show_NhanVien', $viewData);
    }
    public function myProfile($id) //cho tiết.
    {
        $viewData = [
            'NhanVien' => NhanVien::find($id),
            'LoaiNhanVien' => LoaiNhanVien::all(),
        ];
        return view('backend.NhanVien.myProfile_NhanVien', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// edit
    public function edit($id) //trang cập nhật.  (chưa ajax)
    {
        $viewData = [
            'NhanVien' => NhanVien::find($id),
            'LoaiNhanVien' => LoaiNhanVien::where([['id', '!=', "LNV00000000000000"], ['trangthai', 1]])->get(),
        ];
        return view('backend.NhanVien.edit_NhanVien', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// update
    public function update(NhanVienRequest $request, $id) //cập nhật.  (chưa ajax)
    {
        $luong = filter_var($request->luong, FILTER_SANITIZE_NUMBER_INT); // tách dấu phẩy và ký tự.
        if ($luong > 2000000000) { // trả về nếu lớn hơn 2 tỷ.
            return Response()->json(['errors' => 'Lương Phải Nằm Trong Khoảng 0 Đến 2.000.000.000']);
        }

        $data['tennhanvien'] = $request->tennhanvien;
        $data['sdt'] = $request->sdt;
        $data['diachi'] = $request->diachi;
        $data['ngaysinh'] = $request->ngaysinh;
        $data['gioitinh'] = $request->gioitinh;
        $data['email'] = $request->email;
        $data['luong'] = $luong;

        $data['id_loainhanvien'] = $request->id_loainhanvien;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        $OldNhanVien = NhanVien::find($id); //lấy nhân viên củ.
        if ($OldNhanVien->password != $request->password) { //kiểm tra có thay đổ mật khẩu không.
            $data['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('hinhanh')) { //kiểm tra xem có file không.
            $file = $request->hinhanh; //lấy tên hình được gửi lên.
            $extension = $file->extension(); //lấy đui file.
            $path = 'uploads/NhanVien/'; //đường dẫn.
            $data['hinhanh'] = $id . "." . $extension; //sửa lại tên hình ảnh.
            $file->move($path, $data['hinhanh']); //lưu hình ảnh.
        }
        NhanVien::where([
            ['id', '!=', "NV00000000000000"],
            ['id', '!=', "NV11111111111111"],
            ['id', $id]
        ])->update($data);
        $viewData = [
            'NhanVien' => NhanVien::orderBy('created_at', 'desc')->get(),
            'LoaiNhanVien' => LoaiNhanVien::all(),
        ];
        return redirect()->route('nhan-vien.index', $viewData)->with('success', "Thành Công Rồi");
    }
    /////////////////////////////////////////////////////////////////////////////////////////// delete
    public function destroy($id) // xóa.
    {
        $OldNhanVien = NhanVien::find($id); //lấy nhân viên củ
        NhanVien::where(
            [
                ['id', '!=', "NV00000000000000"],
                ['id', '!=', "NV11111111111111"],
                ['id', $id]
            ]
        )->delete();
        if ($OldNhanVien->hinhanh != "NOIMAGE.png") { //kiểm tra có phải đang dùng hình ảnh mặc định không.
            unlink('uploads/NhanVien/' . $OldNhanVien->hinhanh); //xoá ảnh củ.
        }

        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// search
    public function search(Request $request) // tìm.
    {
        $loaiNV = LoaiNhanVien::where([['id', '!=', "LNV00000000000000"], ['id', '!=', "NV11111111111111"], ['tenloainhanvien', $request->search]])->first();
        if ($loaiNV == null) {
            $idLoaiNV = "NULL";
        } else {
            $idLoaiNV = $loaiNV->id;
        }
        $viewData = [
            'NhanVien' => NhanVien::where(
                [['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"], ['tennhanvien', 'like', '%' . $request->search . '%']]
            )->orWhere(
                [['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"], ['sdt', 'like', '%' . $request->search . '%']]
            )->orWhere(
                [['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"], ['id_loainhanvien', $idLoaiNV]]
            )->orderBy('created_at', 'desc')->get(),
            'LoaiNhanVien' => LoaiNhanVien::all(),
        ];
        return view('backend.NhanVien.load_NhanVien', $viewData);
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
        if ($request->filterloai != '0') {
            if ($request->sort == 19) {
                $NhanVien = NhanVien::where([['id_loainhanvien', $request->filterloai], ['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->orderBy('created_at', 'desc')->get();
            } elseif ($request->sort == 29) {
                $NhanVien = NhanVien::where([['id_loainhanvien', $request->filterloai], ['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('created_at', 'asc')->get();
            } elseif ($request->sort == 39) {
                $NhanVien = NhanVien::where([['id_loainhanvien', $request->filterloai], ['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('trangthai', 'desc')->get();
            } else {
                $NhanVien = NhanVien::where([['id_loainhanvien', $request->filterloai], ['id_loainhanvien', $request->filterloai], ['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('trangthai', 'asc')->get();
            }
        } else {
            if ($request->sort == 19) {
                $NhanVien = NhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->orderBy('created_at', 'desc')->get();
            } elseif ($request->sort == 29) {
                $NhanVien = NhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('created_at', 'asc')->get();
            } elseif ($request->sort == 39) {
                $NhanVien = NhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('trangthai', 'desc')->get();
            } else {
                $NhanVien = NhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', "NV00000000000000"], ['id', '!=', "NV11111111111111"]])
                    ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                    ->orderBy('trangthai', 'asc')->get();
            }
        }

        $viewData = [
            'NhanVien' =>  $NhanVien,
            'LoaiNhanVien' => LoaiNhanVien::where('id', '!=', "LNV00000000000000")->get(),
        ];
        return view('backend.NhanVien.load_NhanVien', $viewData);
    }
}
