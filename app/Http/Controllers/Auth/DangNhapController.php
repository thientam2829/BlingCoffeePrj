<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DangNhapController extends Controller
{
    use AuthenticatesUsers;

    // protected $redirectTo = '/create-hoa-don';

    public function index()
    {
        return view('backend.Auth.login');
    }

    public function DangNhap(Request $request)
    {
        $validator = Validator::make(
            $request->all(), // kiểm tra dữ liệu nhập.
            ['sdt' => 'required', 'password' => 'required',]
        );
        if ($validator->fails()) { // trả về nếu có lỗi nhập liệu.
            return redirect()->route('DangNhap.index')->with('errors', "Bạn Cần Nhập Đầy Đủ Thông Tin Đăng Nhập");
        }
        $data = [
            'sdt' => $request->sdt,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $user = NhanVien::where('sdt', $request->sdt)->first();
            Auth::login($user);
            return redirect()->route('hoa-don.create')->with('message', "Xin Chào " . Auth::user()->tennhanvien);
        } else {
            return redirect()->route('DangNhap.index')->with('errors', "Thông Tin Đăng Nhập Không Chính Xác");
        }
    }

    public function DangXuat(Request $request)
    {

        Auth::logout();
        return redirect()->route('DangNhap.index')->with('success', "Đã Đăng Xuất");
    }

    public function username()
    {
        return 'sdt';
    }
}
