<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\QuyCach;
use App\http\Requests\LoaiSanPhamRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LoaiSanPhamController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////// index
    public function index() //danh sách.
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.LoaiSanPham.index', $viewData);
    }
    public function load() // tải lại.
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.LoaiSanPham.load_LoaiSanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// create
    public function create() //trang thêm.
    {
        return view('backend.LoaiSanPham.create_LoaiSanPham');
    }
    /////////////////////////////////////////////////////////////////////////////////////////// store
    public function store(Request $request) //thêm.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            ['tenloaisanpham' => 'required'],
            ['tenloaisanpham.required' => "Tên Loại Sản Phẩm Không Được Để Trống"]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $iddate = "LSP" . Carbon::now('Asia/Ho_Chi_Minh');
        $exp = explode("-", $iddate);
        $imp = implode('', $exp);
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tenloaisanpham'] = $request->tenloaisanpham;
        $data['trangthai'] = $request->trangthai;
        LoaiSanPham::create($data);
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// show
    public function show($id) //trang chi tiết.
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::find($id),
            'QuyCach' => QuyCach::where('id_loaisanpham', $id)->get(),
        ];
        return view('backend.LoaiSanPham.show_LoaiSanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// edit
    public function edit($id) //trang cập nhật.
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::find($id),
        ];
        return view('backend.LoaiSanPham.edit_LoaiSanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// update
    public function update(Request $request, $id) //cập nhật.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            ['tenloaisanpham' => 'required'],
            ['tenloaisanpham.required' => "Tên Loại Sản Phẩm Không Được Để Trống"]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $data['tenloaisanpham'] = $request->tenloaisanpham;
        $data['trangthai'] = $request->trangthai;
        LoaiSanPham::where('id', $id)->update($data);
        return response()->json(['success' => 'Thành Công']);
    }
    public function loadUpdate($id) //tải cập nhật.
    {
        $LoaiSanPham = LoaiSanPham::find($id);
        if ($LoaiSanPham->trangthai == 1) {
            $trangthai = "<span class='badge bg-primary'>Sản phẩm Có Hạn Sử Dụng</span>";
        } elseif ($LoaiSanPham->trangthai == 2) {
            $trangthai = "<span class='badge bg-success'>Sản Phẩm Dùng Trong Ngày</span>";
        } else {
            $trangthai = "<span class='badge bg-danger'>Không Được Phép Thêm Sản Phẩm</span>";
        }
        $output = "
        <td style='text-align: left'>" . $LoaiSanPham->tenloaisanpham . "</td>
        <td>" . $trangthai . "

        </td>
        <td>
            <a href='javascript:(0)' class='action_btn mr_10 view-add' data-url='" . route('quy-cach.create') . "' data-id='" . $LoaiSanPham->id . "'>
                <i class='fas fa-plus-square'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 view-show' data-url='" . route('loai-san-pham.show', $LoaiSanPham->id) . "'>
                <i class='fas fa-eye'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 view-edit' data-url='" . route('loai-san-pham.edit', $LoaiSanPham->id) . "'>
                <i class='fas fa-edit'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 form-delete' data-url='" . route('loai-san-pham.destroy', $LoaiSanPham->id) . "' data-id='" . $LoaiSanPham->id . "'>
                <i class='fas fa-trash-alt'></i></a>
        </td>";
        return $output;
    }
    /////////////////////////////////////////////////////////////////////////////////////////// delete
    public function destroy($id) //xóa.
    {
        LoaiSanPham::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// search
    public function search(Request $request) //tìm.
    {
        $viewData = [
            'LoaiSanPham' => LoaiSanPham::where('tenLoaiSanPham', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->get(),
        ];
        return view('backend.LoaiSanPham.load_LoaiSanPham', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter
    public function filter(Request $request)
    {
        ///////////////////////////////////////// sắp xếp.
        if ($request->sort == 19) {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        ///////////////////////////////////////// trạng thái.
        if ($request->filtertrangthai == 'all') {
            $LoaiSanPham = LoaiSanPham::orderBy('created_at', $sort)->get();
        } elseif ($request->filtertrangthai == 'Expiry') {
            $LoaiSanPham = LoaiSanPham::where('trangthai', 1)
                ->orderBy('created_at', $sort)->get();
        } elseif ($request->filtertrangthai == 'Today') {
            $LoaiSanPham = LoaiSanPham::where('trangthai', 2)
                ->orderBy('created_at', $sort)->get();
        } else {
            $LoaiSanPham = LoaiSanPham::where('trangthai', 0)
                ->orderBy('created_at', $sort)->get();
        }
        $viewData = [
            'LoaiSanPham' =>  $LoaiSanPham,
        ];
        return view('backend.LoaiSanPham.load_LoaiSanPham', $viewData);
    }
}
