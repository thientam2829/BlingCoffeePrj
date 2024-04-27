<?php

namespace App\Http\Controllers\interactive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BinhLuan;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;


class BinhLuanController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////////// danh sách.
    public function index()
    {
        $viewData = [
            'BinhLuan' => BinhLuan::where([['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
                ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                ->select(
                    'binh_luan.*',
                    'san_pham.tensanpham'
                )
                ->orderBy('binh_luan.created_at', 'desc')->paginate(10),
            'SanPham' => SanPham::all(),
        ];
        return view('backend.BinhLuan.index', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// user bình luận.
    public function create(Request $request)
    {
        $iddate = "BL" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['hoten'] = $request->hoten;
        $data['gioitinh'] = $request->gioitinh;
        $data['noidung'] = $request->noidung;
        $data['email'] = $request->email;
        $data['sdt'] = $request->sdt;
        $data['id_sanpham'] = $request->id_sanpham;
        $data['matraloi'] = $request->matraloi;
        $data['thoigian'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['trangthai'] = 0;
        BinhLuan::create($data);
        return redirect()->route('SanPham.show', $data['id_sanpham'])->with('success', 'Chúng tôi sẽ sớm xét duyệt yêu cầu của bạn');
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// đếm số lượng.
    public function countHandleDelivery() //
    {
        $BinhLuan = BinhLuan::where('trangthai', 0)->count();
        echo $BinhLuan;
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////  danh sách cần duyệt.
    public function handleDelivery() // danh sách.
    {
        $viewData = [
            'BinhLuan' => BinhLuan::where('binh_luan.trangthai', '=', '0')
                ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                ->select(
                    'binh_luan.*',
                    'san_pham.tensanpham'
                )
                ->orderBy('binh_luan.created_at', 'desc')->paginate(10),
        ];
        return view('backend.BinhLuan.handleDelivery_BinhLuan', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// chi tiết bình luận.
    public function show($id)
    {
        $TimBinhLuan = BinhLuan::where('binh_luan.id', '=', $id)
            ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
            ->select(
                'binh_luan.*',
                'san_pham.tensanpham',
                'san_pham.hinhanh',
            )->first();
        if ($TimBinhLuan->matraloi != null) {
            $viewData = [
                'BinhLuan' => BinhLuan::where('binh_luan.id', '=', $TimBinhLuan->matraloi)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'TraLoi' => BinhLuan::where('binh_luan.matraloi', '=', $TimBinhLuan->matraloi)->get(),
            ];
        } else {
            $viewData = [
                'BinhLuan' => BinhLuan::where('binh_luan.id', '=', $id)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'TraLoi' => BinhLuan::where('binh_luan.matraloi', '=', $id)->get(),
            ];
        }
        return view('backend.BinhLuan.show_BinhLuan', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// trả lời.
    public function reply(Request $request)
    {
        $iddate = "BL" . Carbon::now('Asia/Ho_Chi_Minh'); //chuỗi thời gian.
        $exp = explode("-", $iddate); //cắt chuỗi.
        $imp = implode('', $exp); //nối chuỗi
        $exp = explode(" ", $imp);
        $imp = implode('', $exp);
        $exp = explode(":", $imp);
        $imp = implode('', $exp);
        $data['id'] = $imp;
        $data['hoten'] = Auth::user()->tennhanvien;
        $data['gioitinh'] = Auth::user()->gioitinh;
        $data['noidung'] = $request->noidung;
        $data['email'] = Auth::user()->email;
        $data['sdt'] = Auth::user()->sdt;
        $data['id_sanpham'] = $request->id_sanpham;
        $data['thoigian'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['matraloi'] = $request->matraloi;
        $data['trangthai'] = 2; // trả lời từ nhân viên.
        BinhLuan::create($data);
        ///////////////////////////////////////// Cập nhật trạng thái đã duyệt.
        $data2['trangthai'] = 1; // đã duyệt.
        BinhLuan::where('id', $request->idreply)->update($data2);
        ///////////////////////////////////////// load lại trả lời bình luận.
        $BinhLuan  = BinhLuan::where('matraloi', $data['matraloi'])->get();
        $output = "";
        foreach ($BinhLuan as $VALUE) {
            $date = Date_format(Date_create($VALUE->thoigian), 'd/m/Y H:i:s');
            $output .= "<div id='Reply" . $VALUE->id . "'><div class='rowuser'>";
            if ($VALUE->trangthai == 2) {
                $output .= "<img src='" . asset('uploads/Logo/logo_bling_coffee.png') . " ' alt='' style='width: 25px'>";
            } else {
                $output .= "<img src='" . asset('uploads/NhanVien/NOIMAGE.png') . "' alt='' style='width: 25px'>";
            }
            $output .= " " . $VALUE->hoten . " - " . $date . "</div>
        <div class='question'>" . $VALUE->noidung . "</div>
        <div class='actionuser'>
        <div class='d-flex justify-content-between'>
            <div class=''>";
            if ($VALUE->trangthai == 2) {
                $output .= "<a class='reply' data-name=' " . $VALUE->hoten . "' data-idreply='" . $data['matraloi'] . "' href='javascript:(0)'>Trả lời</a>";
            } else {
                $output .= "<a class='reply' data-name=' " . $VALUE->hoten . "' data-idreply='" . $VALUE->id . "' href='javascript:(0)'>Trả lời</a>";
            }
            $output .= " </div>
            <div class=''>
            <a class='delete-reply' data-url='" . route('binh-luan.destroyReply', $VALUE->id) . "' data-id='" . $VALUE->id . "' href='javascript:(0)' style='color: red'>Xóa bình luận</a>
            </div>
        </div>
        <hr>
        </div></div>";
        }
        echo $output;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// xóa bình luận góc.
    public function destroy($id)
    {
        BinhLuan::where('id', $id)->delete();
        BinhLuan::where('matraloi', $id)->delete();
        return response()->json(['success' => 'Thành Công ']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// xóa trả lời.
    public function destroyReply($id)
    {
        BinhLuan::where('id', $id)->delete();
        return response()->json(['success' => 'Thành Công ']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// locj & sắp xếp.
    public function filter(Request $request)
    {
        if ($request->sort == 19) {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        if ($request->filtersanpham != 'all') {
            if ($request->filterngay != null) {
                $BinhLuan = BinhLuan::where([['binh_luan.thoigian', 'like',  $request->filterngay . '%'], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0], ['binh_luan.id_sanpham', $request->filtersanpham]])
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham'
                    )
                    ->orderBy('binh_luan.created_at', $sort)->get();
            } else {
                $BinhLuan = BinhLuan::where([['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0], ['binh_luan.id_sanpham', $request->filtersanpham]])
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham'
                    )
                    ->orderBy('binh_luan.created_at', $sort)->get();
            }
        } else {
            if ($request->filterngay != null) {
                $BinhLuan = BinhLuan::where([['binh_luan.thoigian', 'like',  $request->filterngay . '%'], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham'
                    )
                    ->orderBy('binh_luan.created_at', $sort)->get();
            } else {
                $BinhLuan = BinhLuan::where([['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham'
                    )
                    ->orderBy('binh_luan.created_at', $sort)->get();
            }
        }
        $viewData = [
            'BinhLuan' => $BinhLuan,
        ];
        return view('backend.BinhLuan.load_BinhLuan', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// tìm kiếm.
    public function search(Request $request)
    {
        $viewData = [
            'BinhLuan' => BinhLuan::where([['binh_luan.hoten', 'like',  '%' . $request->search . '%'], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
                ->orWhere([['binh_luan.noidung', 'like',   '%' . $request->search . '%'], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
                ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                ->select(
                    'binh_luan.*',
                    'san_pham.tensanpham'
                )
                ->orderBy('binh_luan.created_at', 'desc')->get(),
        ];
        return view('backend.BinhLuan.load_BinhLuan', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////// gửi email.
    public function commentEmail($id, $TT)
    {
        $TimBinhLuan = BinhLuan::where('binh_luan.id', '=', $id)
            ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
            ->select(
                'binh_luan.*',
                'san_pham.tensanpham',
                'san_pham.hinhanh',
            )->first();
        // if ($TimBinhLuan->email == 'SunCoffee137@gmail.com') {
        //     return response()->json(['success' => 'Tự phản hồi']);
        // }
        if ($TimBinhLuan->matraloi != null) {
            $viewData = [
                'TimBinhLuan' => BinhLuan::where('binh_luan.id', '=', $id)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'BinhLuan' => BinhLuan::where('binh_luan.id', '=', $TimBinhLuan->matraloi)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'TraLoi' => BinhLuan::where('binh_luan.matraloi', '=', $TimBinhLuan->matraloi)->get(),
            ];
        } else {
            $viewData = [
                'TimBinhLuan' => BinhLuan::where('binh_luan.id', '=', $id)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'BinhLuan' => BinhLuan::where('binh_luan.id', '=', $id)
                    ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
                    ->select(
                        'binh_luan.*',
                        'san_pham.tensanpham',
                        'san_pham.hinhanh',
                    )->first(),
                'TraLoi' => BinhLuan::where('binh_luan.matraloi', '=', $id)->get(),
            ];
        }
        $to_name = "Bling Coffee";
        $to_email = $TimBinhLuan->email;
        if ($TT == 1) {
            Mail::send('backend.Email.comment_email', $viewData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Báo Đã Duyệt Bình Luận');
                $message->from($to_email, $to_name);
            });
        } else {
            Mail::send('backend.Email.comment_email_cancel', $viewData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Báo Vi Phạm Quy Định Đăng Bình Luận');
                $message->from($to_email, $to_name);
            });
        }
        return response()->json(['success' => 'Đã Gửi Email Thông báo']);
        // return view('backend.Email.comment_email_cancel', $viewData);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////// tìm kiếm.
    public function userSearch(Request $request)
    {
        $BinhLuan = BinhLuan::where([['binh_luan.hoten', 'like',  '%' . $request->keyword . '%'], ['id_sanpham', $request->id], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
            ->orWhere([['binh_luan.noidung', 'like',   '%' . $request->keyword . '%'], ['id_sanpham', $request->id], ['binh_luan.matraloi', '=', null], ['binh_luan.trangthai', '!=', 0]])
            ->join('san_pham', 'san_pham.id', '=', 'binh_luan.id_sanpham')
            ->select(
                'binh_luan.*',
                'san_pham.tensanpham'
            )->orderBy('binh_luan.created_at', 'desc')->get();
        $TraLoi = BinhLuan::where([['id_sanpham', $request->id], ['matraloi', '!=', null], ['trangthai', '!=', 0]])->get();

        $output = '';
        foreach ($BinhLuan as $item) {
            $output .= '
            <hr style="border-top: 1px solid #c49b63;">
            <div class="rowuser">
            <img src="' . asset('uploads/NhanVien/NOIMAGE.png') . '" alt="" style="width: 30px"> ' . $item->hoten . ' - ' . date_format(date_create($item->thoigian), 'd/m/Y H:i:s') . '</div>
            <div class="question">' . $item->noidung . '</div>
            <div class="actionuser"><a class="reply" data-name="' . $item->hoten . '" data-id="' . $item->id . '" href="javascript:(0)">Trả lời</a></div>
            <div class="listreply">';
            foreach ($TraLoi as $itemreply) {
                if ($item->id == $itemreply->matraloi) {
                    $output .= '<div class="rowuserreply">';
                    if ($itemreply->trangthai == 2) {
                        $output .= '<img src="' . asset('uploads/Logo/logo_bling_coffee.png') . '" alt="" style="width: 30px">';
                    } else {
                        $output .= '<img src="' . asset('uploads/NhanVien/NOIMAGE.png') . '" alt="" style="width: 30px">';
                    }
                    $output .= ' ' . $itemreply->hoten . ' - ' . date_format(date_create($itemreply->thoigian), 'd/m/Y H:i:s') . '
                    </div><div class="question">' . $itemreply->noidung . '</div>
                    <div class="actionuser">
                    <a class="reply" data-name="' . $itemreply->hoten . '" data-id="' . $item->id . '" href="javascript:(0)">Trả lời</a>
                    </div>
                    ';
                }
            }
            $output .= '</div>
            <div class="inputreply">
            <div class="form-comment form-comment-reply" id="form-comment-' . $item->id . '" style="display: none;">
                <textarea name="" id="comment-' . $item->id . '" cols="30" rows="3" class="form-control" placeholder="Mời bạn để lại bình luận..."></textarea>
                <div class="d-flex justify-content-between motionsend">
                    <div class=""><a href="javascript:(0)">Quy định đăng bình luận</a></div>
                    <div class="">
                        <button class="btn btn-primary px-4 form-reply" data-id="' . $item->id . '">Gửi</button>
                    </div>
                </div>
            </div>
            <div><span class="lbMsgCmtReply"></span></div>
        </div>';
        }
        return $output;
    }
}
