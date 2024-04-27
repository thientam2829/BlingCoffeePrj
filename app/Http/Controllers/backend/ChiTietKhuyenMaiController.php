<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhuyenMai;
use App\Models\SanPham;
use App\Models\ChiTietSanPham;
use App\Models\ChiTietKhuyenMai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChiTietKhuyenMaiController extends Controller
{

    public function create($id) // trang thêm chi tiết.
    {
        $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.trangthai', '=', '1')
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->where('san_pham.trangthai', '=', '1')
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->where('san_pham.trangthai', '=', '1')
            ->select(
                'san_pham.tensanpham',
                'chi_tiet_san_pham.id',
                'quy_cach.tenquycach',
            )->get();
        $viewData = [
            'KhuyenMai' => KhuyenMai::find($id),
            'ChiTietSanPham' => $ChiTietSanPham,
        ];
        return view('backend.ChiTietKhuyenMai.create_ChiTietKhuyenMai', $viewData);
    }

    public function store(Request $request) // thêm chi tiết.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'id_chitietsanpham' => 'required',
                'muckhuyenmai' => 'required',
            ],
            [
                'id_chitietsanpham.required' => 'Sản Phẩm Không Được Để Trống',

                'muckhuyenmai.required' => 'Mức Khuyến Mãi Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->muckhuyenmai > 100) { // kiểm tra mức khuyến mãi.
            return response()->json(['errors' => 'Mức Khuyến Mãi Phải Nhỏ Hơn Hoặc Bằng 100']);
        }

        $OldChiTietKhuyenMai = ChiTietKhuyenMai::where([
            ['id_chitietsanpham', $request->id_chitietsanpham],
            ['id_khuyenmai', $request->id_khuyenmai],
        ])->first();
        if ($OldChiTietKhuyenMai == null) { // cập nhật lại khi đã tồn tại.
            $data['id_chitietsanpham'] = $request->id_chitietsanpham;
            $data['id_khuyenmai'] = $request->id_khuyenmai;
            $data['muckhuyenmai'] = $request->muckhuyenmai;
            ChiTietKhuyenMai::create($data);
            return response()->json(['success' => 'Thành Công ']);
        } else {
            $data['id_chitietsanpham'] = $request->id_chitietsanpham;
            $data['id_khuyenmai'] = $request->id_khuyenmai;
            $data['muckhuyenmai'] = $request->muckhuyenmai;
            ChiTietKhuyenMai::where([
                ['id_chitietsanpham', $request->id_chitietsanpham],
                ['id_khuyenmai', $request->id_khuyenmai],
            ])->update($data);
            return response()->json(['success' => 'Đã Cập Nhật ']);
        }
    }

    public function edit($idCTSP, $idKM) // trang chi tiết.
    {
        $ChiTietSanPham = ChiTietSanPham::where('chi_tiet_san_pham.id', '=', $idCTSP)
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'san_pham.tensanpham',
                'chi_tiet_san_pham.id',
                'quy_cach.tenquycach',
            )->first();
        $viewData = [
            'KhuyenMai' => KhuyenMai::find($idKM),
            'ChiTietKhuyenMai' => ChiTietKhuyenMai::where([['id_chitietsanpham', $idCTSP], ['id_khuyenmai', $idKM]])->first(),
            'ChiTietSanPham' =>  $ChiTietSanPham,
        ];
        return view('backend.ChiTietKhuyenMai.edit_ChiTietKhuyenMai', $viewData);
    }

    public function update(Request $request, $idCTSP, $idKM) // cập nhật chi tiết.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'id_chitietsanpham' => 'required',
                'id_khuyenmai' => 'required',
                'muckhuyenmai' => 'required',
            ],
            [
                'id_chitietsanpham.required' => 'Sản Phẩm Không Được Để Trống',

                'muckhuyenmai.required' => 'Mức Khuyến Mãi Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->muckhuyenmai > 100) { // kiểm tra mức khuyến mãi.
            return response()->json(['errors' => 'Mức Khuyến Mãi Phải Nhỏ Hơn 100']);
        }

        $data['id_chitietsanpham'] = $request->id_chitietsanpham;
        $data['id_khuyenmai'] = $request->id_khuyenmai;
        $data['muckhuyenmai'] = $request->muckhuyenmai;
        ChiTietKhuyenMai::where([
            ['id_chitietsanpham', $idCTSP],
            ['id_khuyenmai', $idKM],
        ])->update($data);
        return response()->json(['success' => 'Thành Công']);
    }

    public function destroy($idCTSP, $idKM)
    {
        ChiTietKhuyenMai::where([['id_chitietsanpham', $idCTSP], ['id_khuyenmai', $idKM]])->delete();
        return response()->json(['success' => 'Thành Công ']);
    }
}
