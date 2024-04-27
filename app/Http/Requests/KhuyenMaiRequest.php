<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhuyenMaiRequest extends FormRequest
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
            'tenkhuyenmai' => 'required',
            'thoigianbatdau' => 'required|date',
            'thoigianketthuc' => 'required|date|after:thoigianbatdau',
            'muckhuyenmaitoida' => 'required',
            'mota' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'tenkhuyenmai.required' => 'Tên Khuyến Mãi Không Được Để Trống',

            'thoigianbatdau.required' => 'Thời Gian Bắt Đầu Không Được Để Trống',
            'thoigianbatdau.date' => 'Thời Gian Bắt Không Đúng Đinh Dạng Ngày',

            'thoigianketthuc.required' => 'Thời Gian Kết Thúc Không Được Để Trống',
            'thoigianketthuc.date' => 'Thời Gian Kết Thúc Không Đúng Đinh Dạng Ngày',
            'thoigianketthuc.after' => 'Thời Gian Kết Thúc Phải Sau Thời Gian Bắt Đầu',

            'muckhuyenmaitoida.required' => 'Mức Khuyến Mãi Tối Đa Không Được Để Trống',

            'mota.required' => 'Mô Tả Không Được Để Trống',
        ];
    }
}
