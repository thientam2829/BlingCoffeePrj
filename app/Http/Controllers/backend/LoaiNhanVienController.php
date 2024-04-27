<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiNhanVien;
use App\http\Requests\LoaiNhanVienRequest;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LoaiNhanVienController extends Controller
{

    public function index() //danh sách.
    {
        $viewData = [
            'LoaiNhanVien' => LoaiNhanVien::where('id', '!=', "LNV00000000000000")->orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.LoaiNhanVien.index', $viewData);
    }

    public function load() //tải lại.
    {
        $viewData = [
            'LoaiNhanVien' => LoaiNhanVien::where('id', '!=', "LNV00000000000000")->orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.LoaiNhanVien.load_LoaiNhanVien', $viewData);
    }

    public function search(Request $request) //tìm.
    {
        $viewData = [
            'LoaiNhanVien' => LoaiNhanVien::where(
                [['id', '!=', "LNV00000000000000"], ['tenloainhanvien', 'like', '%' . $request->search . '%']]
            )->orderBy('created_at', 'desc')->get(),
        ];
        return view('backend.LoaiNhanVien.load_LoaiNhanVien', $viewData);
    }

    public function create() // trang thêm.
    {
        return view('backend.LoaiNhanVien.create_LoaiNhanVien');
    }

    public function store(Request $request) // thêm.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            ['tenloainhanvien' => 'required'],
            ['tenloainhanvien.required' => "Tên Loại Nhân Viên Không Được Để Trống"]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $iddate = "LNV" . Carbon::now('Asia/Ho_Chi_Minh');
        $exp = explode("-", $iddate);
        $imp = implode('', $exp);
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tenloainhanvien'] = $request->tenloainhanvien;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        LoaiNhanVien::create($data);
        return response()->json(['success' => 'Thành Công ']);
    }

    public function edit($id) //trang cập nhật.
    {
        $viewData = [
            'LoaiNhanVien' => LoaiNhanVien::find($id)
        ];
        return view('backend.LoaiNhanVien.edit_LoaiNhanVien', $viewData);
    }

    public function update(Request $request, $id) //cập nhật.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            ['tenloainhanvien' => 'required'],
            ['tenloainhanvien.required' => "Tên Loại Nhân Viên Không Được Để Trống"]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $data['tenloainhanvien'] = $request->tenloainhanvien;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        LoaiNhanVien::where('id', $id)->update($data);
        return response()->json(['success' => 'Thành Công Rồi']);
    }

    public function destroy($id) //xóa.
    {
        LoaiNhanVien::where(
            [['id', '!=', "LNV00000000000000"], ['id', $id]]
        )->delete();
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter
    public function filter(Request $request)
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
            $LoaiNhanVien = LoaiNhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'LNV00000000000000']])
                ->orderBy('created_at', 'desc')->get();
        } elseif ($request->sort == 29) {
            $LoaiNhanVien = LoaiNhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'LNV00000000000000']])
                ->orderBy('created_at', 'asc')->get();
        } elseif ($request->sort == 39) {
            $LoaiNhanVien = LoaiNhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'LNV00000000000000']])
                ->orderBy('trangthai', 'desc')->get();
        } else {
            $LoaiNhanVien = LoaiNhanVien::where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'LNV00000000000000']])
                ->orderBy('trangthai', 'asc')->get();
        }
        $viewData = [
            'LoaiNhanVien' =>  $LoaiNhanVien,
        ];
        return view('backend.LoaiNhanVien.load_LoaiNhanVien', $viewData);
    }
}
