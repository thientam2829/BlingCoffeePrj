<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\ChiTietSanPham;
use App\Models\QuyCach;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class QuyCachController extends Controller
{
    public function create(Request $request)
    {
        $viewData = [
            'id_loaisanpham' => $request->id,
        ];
        return view('backend.QuyCach.create_QuyCach', $viewData);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenquycach' => 'required',
                'id_loaisanpham' => 'required',
            ],
            [
                'tenquycach.required' => 'Tên Quy Cách Không Được Để Trống',

                'id_loaisanpham.required' => 'Mã Loại Sản phẩm Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        $iddate = "QC" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tenquycach'] = $request->tenquycach;
        $data['id_loaisanpham'] = $request->id_loaisanpham;
        $data['trangthai'] = $request->trangthai;
        QuyCach::create($data);
        return response()->json(['success' => 'Thành Công']);
    }

    public function edit($id)
    {
        $viewData = [
            'QuyCach' => QuyCach::find($id),
        ];
        return view('backend.QuyCach.edit_QuyCach', $viewData);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenquycach' => 'required',
                'id_loaisanpham' => 'required',
            ],
            [
                'tenquycach.required' => 'Tên Quy Cách Không Được Để Trống',

                'id_loaisanpham.required' => 'Mã Loại Sản phẩm Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        $data['tenquycach'] = $request->tenquycach;
        $data['id_loaisanpham'] = $request->id_loaisanpham;
        $data['trangthai'] = $request->trangthai;
        QuyCach::where('id', $id)->update($data);
        return response()->json(['success' => 'Thành Công']);
    }

    public function destroy($id)
    {
        $QuyCach = QuyCach::find($id);
        ChiTietSanPham::where('kichthuoc', $QuyCach->id)->delete();
        QuyCach::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công']);
    }
}
