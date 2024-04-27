<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\SanPham;
use App\Models\ChiTietSanPham;
use App\Models\LoaiSanPham;
use App\http\Requests\KhuyenMaiRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class KhuyenMaiController extends Controller
{

    public function index() //danh sách.
    {
        $viewData = [
            'KhuyenMai' => KhuyenMai::orderBy('created_at', 'desc')->paginate(10),
            'today' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'), // lấy ngày hiện tại.
        ];
        return view('backend.KhuyenMai.index', $viewData);
    }

    public function create() // trang thêm.
    {
        return view('backend.KhuyenMai.create_KhuyenMai');
    }

    public function store(Request $request) // thêm.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenkhuyenmai' => 'required',
                'thoigianbatdau' => 'required|date',
                'thoigianketthuc' => 'required|date|after_or_equal:thoigianbatdau',
                'mota' => 'required',
            ],
            [
                'tenkhuyenmai.required' => 'Tên Khuyến Mãi Không Được Để Trống',

                'thoigianbatdau.required' => 'Thời Gian Bắt Đầu Không Được Để Trống',
                'thoigianbatdau.date' => 'Thời Gian Bắt Không Đúng Đinh Dạng Ngày',

                'thoigianketthuc.required' => 'Thời Gian Kết Thúc Không Được Để Trống',
                'thoigianketthuc.date' => 'Thời Gian Kết Thúc Không Đúng Đinh Dạng Ngày',
                'thoigianketthuc.after_or_equal' => 'Thời Gian Kết Thúc Phải Bằng Hoặc Sau Thời Gian Bắt Đầu',

                'mota.required' => 'Mô Tả Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $iddate = "KM" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['tenkhuyenmai'] = $request->tenkhuyenmai;
        $data['thoigianbatdau'] = $request->thoigianbatdau;
        $data['thoigianketthuc'] = $request->thoigianketthuc;
        $data['mota'] = $request->mota;
        $data['trangthai'] = $request->trangthai;
        KhuyenMai::create($data);
        return response()->json(['success' => 'Thành Công ']);
    }

    public function load() // tải lại.
    {
        $viewData = [
            'KhuyenMai' => KhuyenMai::orderBy('created_at', 'desc')->paginate(10),
            'today' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'), // lấy ngày hiện tại.
        ];
        return view('backend.KhuyenMai.load_KhuyenMai', $viewData);
    }

    public function show($id) // chi tiết.
    {

        $ChiTietKhuyenMai = ChiTietKhuyenMai::where('chi_tiet_khuyen_mai.id_khuyenmai', $id)
            ->join('chi_tiet_san_pham', 'chi_tiet_san_pham.id', '=', 'chi_tiet_khuyen_mai.id_chitietsanpham')
            ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_san_pham.id_sanpham')
            ->join('loai_san_pham', 'loai_san_pham.id', '=', 'san_pham.id_loaisanpham')
            ->join('quy_cach', 'quy_cach.id', '=', 'chi_tiet_san_pham.kichthuoc')
            ->select(
                'chi_tiet_khuyen_mai.*',
                'san_pham.tensanpham',
                'loai_san_pham.tenloaisanpham',
                'quy_cach.tenquycach',
            )->orderBy('updated_at', 'desc')
            ->get();
        $viewData = [
            'today' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'), // lấy ngày hiện tại.
            'KhuyenMai' => KhuyenMai::find($id),
            'ChiTietKhuyenMai' => $ChiTietKhuyenMai,

        ];
        return view('backend.KhuyenMai.show_KhuyenMai', $viewData);
    }

    public function edit($id) // trang cập nhật.
    {
        $viewData = [
            'KhuyenMai' => KhuyenMai::find($id),
        ];
        return view('backend.KhuyenMai.edit_KhuyenMai', $viewData);
    }

    public function update(Request $request, $id) // cập nhật.
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            [
                'tenkhuyenmai' => 'required',
                'thoigianbatdau' => 'required|date',
                'thoigianketthuc' => 'required|date|after_or_equal:thoigianbatdau',
                'mota' => 'required',
            ],
            [
                'tenkhuyenmai.required' => 'Tên Khuyến Mãi Không Được Để Trống',

                'thoigianbatdau.required' => 'Thời Gian Bắt Đầu Không Được Để Trống',
                'thoigianbatdau.date' => 'Thời Gian Bắt Không Đúng Đinh Dạng Ngày',

                'thoigianketthuc.required' => 'Thời Gian Kết Thúc Không Được Để Trống',
                'thoigianketthuc.date' => 'Thời Gian Kết Thúc Không Đúng Đinh Dạng Ngày',
                'thoigianketthuc.after_or_equal' => 'Thời Gian Kết Thúc Phải Bằng Hoặc Sau Thời Gian Bắt Đầu',

                'mota.required' => 'Mô Tả Không Được Để Trống',
            ]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return Response()->json(['errors' => $validator->errors()->all()]);
        }

        $data['tenkhuyenmai'] = $request->tenkhuyenmai;
        $data['thoigianbatdau'] = $request->thoigianbatdau;
        $data['thoigianketthuc'] = $request->thoigianketthuc;
        $data['mota'] = $request->mota;
        $data['trangthai'] = $request->trangthai;
        KhuyenMai::where('id', $id)->update($data);
        return response()->json(['success' => 'Thành Công']);
    }

    public function loadUpdate($id) //tải cập nhật.
    {
        $KhuyenMai = KhuyenMai::find($id);
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.


        if ($KhuyenMai->thoigianketthuc < $today) {
            $tinhtrang = "<span class='badge bg-danger'>Kết Thúc</span>";
        } elseif ($KhuyenMai->trangthai == 0 && $KhuyenMai->thoigianketthuc >= $today) {
            $tinhtrang = "<span class='badge bg-warning'>Đã Khóa</span>";
        } elseif ($KhuyenMai->thoigianbatdau > $today) {
            $tinhtrang = "<span class='badge bg-info'>Sắp Đến</span>";
        } else {
            $tinhtrang = "<span class='badge bg-primary'>Đang Áp Dụng</span>";
        }
        $output = "
        <td style='text-align: left'>" . $KhuyenMai->tenkhuyenmai . "</td>
        <td>" . Date_format(Date_create($KhuyenMai->thoigianbatdau), 'd/m/Y') . "</td>
        <td>" . Date_format(Date_create($KhuyenMai->thoigianketthuc), 'd/m/Y') . "</td>
        <td>" . $tinhtrang . "</td>
        <td>
            <a href='javascript:(0)' class='action_btn mr_10 view-add'
                data-url='" . route('chi-tiet-khuyen-mai.create', $KhuyenMai->id) . "'
                data-id='" . $KhuyenMai->id . "'>
                <i class='fas fa-plus-square'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 view-show'
                data-url='" . route('khuyen-mai.show', $KhuyenMai->id) . "'
                data-id='" . $KhuyenMai->id . "'>
                <i class='fas fa-eye'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 view-edit'
                data-url='" . route('khuyen-mai.edit', $KhuyenMai->id) . "'
                data-id='" . $KhuyenMai->id . "'>
                <i class='fas fa-edit'></i></a>

            <a href='javascript:(0)' class='action_btn mr_10 form-delete'
                data-url='" . route('khuyen-mai.destroy', $KhuyenMai->id) . "'
                data-id='" . $KhuyenMai->id . "'>
                <i class='fas fa-trash-alt'></i></a>
        </td>";
        return $output;
    }

    public function destroy($id) //xóa.
    {
        ChiTietKhuyenMai::where('id_khuyenmai', $id)->delete();
        KhuyenMai::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công']);
    }

    public function search(Request $request) //tìm.
    {
        $viewData = [
            'KhuyenMai' => KhuyenMai::where('tenkhuyenmai', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->get(),
            'today' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'), // lấy ngày hiện tại.
        ];
        return view('backend.KhuyenMai.load_KhuyenMai', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// filter
    public function filter(Request $request) //tìm.
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // lấy ngày hiện tại.
        ///////////////////////////////////////// sắp Xếp.
        if ($request->sort == 19) {
            $orderBy = 'desc';
        } else {
            $orderBy = 'asc';
        }
        ///////////////////////////////////////// ngày khuyến mãi.
        if ($request->filterngay != null) {
            if ($request->filtertrangthai == 'all') {
                $KhuyenMai = KhuyenMai::where([
                    ['thoigianbatdau', '<=', $request->filterngay],
                    ['thoigianketthuc', '>=', $request->filterngay],
                ])->orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'come') {
                $KhuyenMai = KhuyenMai::where([
                    ['thoigianbatdau', '<=', $request->filterngay],
                    ['thoigianketthuc', '>=', $request->filterngay],
                    ['thoigianbatdau', '>', $today],
                    ['trangthai', 1]
                ])->orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'apply') {
                $KhuyenMai = KhuyenMai::where([
                    ['thoigianbatdau', '<=', $request->filterngay],
                    ['thoigianketthuc', '>=', $request->filterngay],
                    ['thoigianbatdau', '>=', $today],
                    ['thoigianketthuc', '<=', $today],
                    ['trangthai', 1]
                ])->orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'end') {
                $KhuyenMai = KhuyenMai::where([
                    ['thoigianbatdau', '<=', $request->filterngay],
                    ['thoigianketthuc', '>=', $request->filterngay],
                    ['thoigianketthuc', '<', $today],
                    ['trangthai', 1]
                ])->orderBy('created_at',  $orderBy)->get();
            } else {
                $KhuyenMai = KhuyenMai::where([
                    ['thoigianbatdau', '<=', $request->filterngay],
                    ['thoigianketthuc', '>=', $request->filterngay],
                    ['trangthai', 0]
                ])->orderBy('created_at',  $orderBy)->get();
            }
        } else {
            if ($request->filtertrangthai == 'all') {
                $KhuyenMai = KhuyenMai::orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'come') {
                $KhuyenMai = KhuyenMai::where([['thoigianbatdau', '>', $today], ['trangthai', 1]])->orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'apply') {
                $KhuyenMai = KhuyenMai::where([['thoigianbatdau', '<=', $today], ['thoigianketthuc', '>=', $today], ['trangthai', 1]])->orderBy('created_at',  $orderBy)->get();
            } elseif ($request->filtertrangthai == 'end') {
                $KhuyenMai = KhuyenMai::where([['thoigianketthuc', '<', $today], ['trangthai', 1]])->orderBy('created_at',  $orderBy)->get();
            } else {
                $KhuyenMai = KhuyenMai::where('trangthai', 0)->orderBy('created_at',  $orderBy)->get();
            }
        }
        $viewData = [
            'KhuyenMai' => $KhuyenMai,
            'today' => $today,
        ];
        return view('backend.KhuyenMai.load_KhuyenMai', $viewData);
    }
}
