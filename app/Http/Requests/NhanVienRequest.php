<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tennhanvien' => 'required',
            'sdt' => 'required|min:10|unique:nhan_vien,sdt,' . $this->id,
            'diachi' => 'required',
            'ngaysinh' => 'required',
            'gioitinh' => 'required',
            'hinhanh' => 'image|max:2048',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
            'password_confirm' => 'required|same:password',
            'id_loainhanvien' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'tennhanvien.required' => 'Tên Nhân Viên Không Được Để Trống',

            'sdt.required' => 'Số Điện Thoại Không Được Bỏ Trống',
            'sdt.unique' => 'Số Điện Thoại Đã Tồ Tại',
            'sdt.min' => 'Số Điện Thoại Không Đủ 10 Số',

            'email.required' => 'Email Không Được Bỏ Trống',
            'email.email' => 'Email Không Hợp Lệ',

            'diachi.required' => 'Địa Chỉ Không Được Để Trống',

            'ngaysinh.required' => 'Ngày Sinh Không Được Để Trống',

            'gioitinh.required' => 'Giới Tính Không Được Để Trống',

            'hinhanh.image' => 'Hãy Chọn Một Tệp Hình Ảnh',
            'hinhanh.max' => 'Tệp Hình Ảnh Không Được Lớn Hơn 2MB',

            'tentaikhoan.required' => 'Tên Tài Khoản Không Được Để Trống',
            'tentaikhoan.min' => 'Tên Tài Khoản Phải Nhỏ Hơn 2 Ký Tự',

            'password.required' => 'Mật Khẩu Không Được Để Trống',
            'password.min' => 'Mật Khẩu Phải Lớn Hơn 5 Ký Tự',

            'password_confirm.required' => 'Mật Khẩu Không Được Để Trống',
            'password_confirm.same' => 'Mật Khẩu Không Trùng Khớp',

            'id_loainhanvien.required' => 'Mã Nhân Viên Không Được Để Trống',
        ];
    }
}
