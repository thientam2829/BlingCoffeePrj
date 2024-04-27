<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\QuyCach;
use App\Models\LoaiSanPham;
use App\Models\ChiTietSanPham;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChiTietSanPhamController extends Controller
{

    public function create($id) //trang thêm chi tiết.
    {
        $SanPham = SanPham::find($id);
        $LoaiSanPham = LoaiSanPham::where('id', $SanPham->id_loaisanpham)->first();
        $viewData = [
            'SanPham' => $SanPham,
            'LoaiSanPham' => $LoaiSanPham,
            'QuyCach' => QuyCach::where([['id_loaisanpham', $LoaiSanPham->id], ['trangthai', '!=', 0]])->get(),
        ];
        return view('backend.ChiTietSanPham.create_ChiTietSanPham', $viewData);
    }

    public function store(Request $request) //thêm chi tiết.
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


        $iddate = "CTSP" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['kichthuoc'] = $request->kichthuoc;
        $data['soluong'] = $soluong;
        $data['giasanpham'] = $giasanpham;
        $data['ngaysanxuat'] = $request->ngaysanxuat;
        $data['hansudung'] = $request->hansudung;
        $data['id_sanpham'] = $request->id_sanpham;
        $data['trangthai'] = $request->trangthai;
        ChiTietSanPham::create($data);
        return response()->json(['success' => 'Thành Công ']);
    }

    public function edit($id) //trang cập nhật chi tiết.
    {
        $ChiTietSanPham = ChiTietSanPham::find($id);
        $SanPham = SanPham::where('id', $ChiTietSanPham->id_sanpham)->first();
        $LoaiSanPham = LoaiSanPham::where('id', $SanPham->id_loaisanpham)->first();
        $viewData = [
            'ChiTietSanPham' =>  $ChiTietSanPham,
            'LoaiSanPham' => $LoaiSanPham,
            'QuyCach' => QuyCach::where([['id_loaisanpham', $LoaiSanPham->id], ['trangthai', '!=', 0]])->get(),
        ];
        return view('backend.ChiTietSanPham.edit_ChiTietSanPham', $viewData);
    }

    public function update(Request $request, $id) //cập nhật chi tiết.
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
        return response()->json(['success' => 'Thành Công']);
    }

    public function destroy($id) //xóa chi tiết.
    {
        ChiTietSanPham::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công']);
    }
}
