<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTietSanPhamRequest extends FormRequest
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
            'kichthuoc' => 'required',
            'soluong' => 'required|integer|between:0,10000',
            'giasanpham' => 'required|integer|between:0,1000000000',
            'ngaysanxuat' => 'required|date',
            'hansudung' => 'required|date|after:ngaysanxuat',
        ];
    }
    public function messages()
    {
        return [
            'kichthuoc.required' => 'Quy Cách Không Được Để Trống',

            'soluong.required' => 'Số Lượng Không Được Để Trống',
            'soluong.integer' => 'Số Lượng Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',
            'soluong.between' => 'Số Lượng Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',

            'giasanpham.required' => 'Giá Sản Phẩm Không Được Để Trống',
            'giasanpham.integer' => 'Giá Sản Phẩm Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',
            'giasanpham.between' => 'Giá Sản Phẩm Phải Nằm Trong Khoảng 0 Đến 1.000.000.000',

            'ngaysanxuat.required' => 'Ngày Sản Xuất Không Được Để Trống',
            'ngaysanxuat.date' => 'Ngày Sản Xuất Không Đúng Định Dạng Ngày',

            'hansudung.required' => 'Hạn Sử Dụng Không Được Để Trống',
            'hansudung.date' => 'Hạn Sử Dụng Không Đúng Định Dạng Ngày',
            'hansudung.after' => 'Hạn Sử Dụng Phải Sau Ngày Sản Xuất',
        ];
    }
}
