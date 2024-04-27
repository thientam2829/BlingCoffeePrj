<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanPhamRequest extends FormRequest
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
            'tensanpham' => 'required',
            'hinhanh' => 'image|max:2048',
            'id_loaisanpham' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'tensanpham.required' => 'Tên Sản Phẩm Không Được Để Trống',

            'hinhanh.image' => 'Hãy Chọn Một Tệp Hình Ảnh',
            'hinhanh.max' => 'Tệp Hình Ảnh Không Được Lớn Hơn 2MB',

            'id_loaisanpham.required' => 'Mã Sản Phẩm Không Được Để Trống',
        ];
    }
}
