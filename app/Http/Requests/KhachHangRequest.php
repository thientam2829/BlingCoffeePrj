<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangRequest extends FormRequest
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
            'tenkhachhang' => 'required',
            'sdt' => 'required|min:10|unique:khach_hang,sdt,' . $this->id,
            'diachi' => 'required',
            'diemtichluy' => 'required|integer|between:0,1000000000',
        ];
    }
    public function messages()
    {
        return [
            'tenkhachhang.required' => 'Tên Khách Hàng Không Được Để Trống',

            'sdt.required' => 'Số Điện Thoại Không Được Để Trống',
            'sdt.unique' => 'Số Điện Thoại Đã Tồn Tại',
            'sdt.min' => 'Số Điện Thoại không Đủ 10 số',

            'diachi.required' => 'Địa Chỉ Không Được Để Trống',

            'diemtichluy.required' => 'Điểm Tích Luỹ Không Được Để Trống',
            'diemtichluy.integer' => 'Điểm Tích Luỹ Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',
            'diemtichluy.between' => 'Điểm Tích Luỹ Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',
        ];
    }
}
