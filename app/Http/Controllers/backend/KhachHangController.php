<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachHang;
use App\http\Requests\KhachHangRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class KhachHangController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////// index
    public function index() // danh sách.
    {
        $viewData = [
            'KhachHang' => KhachHang::where('id', '!=', 'KH00000000000000')->orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.KhachHang.index', $viewData);
    }
    public function load() // tải lại.
    {
        $viewData = [
            'KhachHang' => KhachHang::where('id', '!=', 'KH00000000000000')->orderBy('created_at', 'desc')->paginate(10),
        ];
        return view('backend.KhachHang.load_KhachHang', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// create
    public function create() //trang thêm.
    {
        return view('backend.KhachHang.create_KhachHang');
    }
    /////////////////////////////////////////////////////////////////////////////////////////// store
    public function store(Request $request) //thêm.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenkhachhang' => 'required',
                'sdt' => 'required|min:10|unique:khach_hang,sdt',
                'diachi' => 'required',
                'email' => 'required|email',
                'diemtichluy' => 'required',
            ],
            [
                'tenkhachhang.required' => 'Tên Khách Hàng Không Được Để Trống',

                'sdt.required' => 'Số Điện Thoại Không Được Để Trống',
                'sdt.unique' => 'Số Điện Thoại Đã Tồn Tại',
                'sdt.min' => 'Số Điện Thoại không Đủ 10 số',

                'email.required' => 'Email Không Được Bỏ Trống',
                'email.email' => 'Email Không Hợp Lệ',

                'diachi.required' => 'Địa Chỉ Không Được Để Trống',

                'diemtichluy.required' => 'Điểm Tích Luỹ Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $iddate = "KH" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tenkhachhang'] = $request->tenkhachhang;
        $data['sdt'] = $request->sdt;
        $data['diachi'] = $request->diachi;
        $data['email'] = $request->email;
        $data['diemtichluy'] = $request->diemtichluy;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        KhachHang::create($data);
        return response()->json(['success' => 'Thành Công']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// edit
    public function edit($id) //trang cập nhật.
    {
        $viewData = [
            'KhachHang' => KhachHang::find($id),
        ];
        return view('backend.KhachHang.edit_KhachHang', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// update
    public function update(Request $request, $id) //cập nhật.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenkhachhang' => 'required',
                'sdt' => 'required|min:10|unique:khach_hang,sdt,' . $id,
                'diachi' => 'required',
                'email' => 'required|email',
                'diemtichluy' => 'required',
            ],
            [
                'tenkhachhang.required' => 'Tên Khách Hàng Không Được Để Trống',

                'sdt.required' => 'Số Điện Thoại Không Được Để Trống',
                'sdt.unique' => 'Số Điện Thoại Đã Tồn Tại',
                'sdt.min' => 'Số Điện Thoại không Đủ 10 số',

                'email.required' => 'Email Không Được Bỏ Trống',
                'email.email' => 'Email Không Hợp Lệ',

                'diachi.required' => 'Địa Chỉ Không Được Để Trống',

                'diemtichluy.required' => 'Điểm Tích Luỹ Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        $money = filter_var($request->diemtichluy, FILTER_SANITIZE_NUMBER_INT); // tách dấu phẩy và ký tự.
        if ($money > 2000000000) { // trả về nếu lớn hơn 2 tỷ.
            return Response()->json(['errors' => 'Điểm Tích Luỹ Phải Nằm Trong Khoảng 0 Đến 2.000.000.000']);
        }
        $data['tenkhachhang'] = $request->tenkhachhang;
        $data['sdt'] = $request->sdt;
        $data['diachi'] = $request->diachi;
        $data['email'] = $request->email;
        $data['diemtichluy'] = $money;
        $data['trangthai'] = $request->trangthai;
        if (empty($request->trangthai)) {
            $data['trangthai'] = 0;
        }
        KhachHang::where('id', $id)->update($data);
        return response()->json(['success' => 'Thành Công ']);
    }
    public function loadUpdate($id) //tải cập nhật.
    {
        $KhachHang = KhachHang::find($id);
        if ($KhachHang->trangthai == 1) {
            $trangthai = '<span class="badge bg-success">Được Dùng</span>';
        } else {
            $trangthai = '<span class="badge bg-danger">Đã Khoá</span>';
        }

        $output = "
        <td style='text-align: left'>" . $KhachHang->tenkhachhang . "</td>
        <td>" . $KhachHang->sdt . "</td>
        <td style='text-align: left; width: 20%'>" . $KhachHang->diachi . "</td>
        <td style='text-align: left'>" . $KhachHang->email . "</td>
        <td>" . number_format($KhachHang->diemtichluy, 0, ',', '.') . "</td>
        <td>" . $trangthai . "</td>
        <td>
        <div class='d-flex'>
        <a href='javascript:(0)' class='action_btn mr_10 view-edit' data-url='" . route('khach-hang.edit', $KhachHang->id) . "'>
        <i class='fas fa-edit'></i></a>
        <a href='javascript:(0)' class='action_btn mr_10 form-delete' data-url='" . route('khach-hang.destroy', $KhachHang->id) . "' data-id='" . $KhachHang->id . "'>
        <i class='fas fa-trash-alt'></i></a></td></div>";
        return $output;
    }
    /////////////////////////////////////////////////////////////////////////////////////////// delete
    public function destroy($id) //xóa.
    {
        KhachHang::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công ']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// search
    public function search(Request $request)
    {
        $viewData = [
            'KhachHang' => KhachHang::where([['id', '!=', 'KH00000000000000'], ['tenKhachHang', 'like', '%' . $request->search . '%']])
                ->orwhere([['id', '!=', 'KH00000000000000'], ['sdt', 'like', '%' . $request->search . '%']])
                ->orderBy('created_at', 'desc')->get(),
        ];
        return view('backend.KhachHang.load_KhachHang', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter
    public function filter(Request $request) //tìm.
    {
        ///////////////////////////////////////// diểm tích lũy.
        if ($request->filterdiem == 1) {
            $filterdiem[] = [0, 999];
        } elseif ($request->filterdiem == 2) {
            $filterdiem[] = [1000, 4999];
        } elseif ($request->filterdiem == 3) {
            $filterdiem[] = [5000, 9999];
        } elseif ($request->filterdiem == 4) {
            $filterdiem[] = [10000, 99999];
        } elseif ($request->filterdiem == 5) {
            $filterdiem[] = [100000, 2000000000];
        } else {
            $filterdiem[] = [0, 2000000000];
        }
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
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('created_at', 'desc')->get();
        } elseif ($request->sort == 29) {
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('created_at', 'asc')->get();
        } elseif ($request->sort == 39) {
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('trangthai', 'desc')->get();
        } elseif ($request->sort == 49) {
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('trangthai', 'asc')->get();
        } elseif ($request->sort == 59) {
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('diemtichluy', 'desc')->get();
        } else {
            $KhachHang = KhachHang::whereBetween('diemtichluy', $filterdiem)
                ->where([['trangthai', '!=', $filtertrangthai], ['id', '!=', 'KH00000000000000']])
                ->orderBy('diemtichluy', 'asc')->get();
        }
        $viewData = [
            'KhachHang' =>  $KhachHang,
        ];
        return view('backend.KhachHang.load_KhachHang', $viewData);
    }
}
