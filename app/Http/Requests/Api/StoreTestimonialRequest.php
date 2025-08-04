<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng gửi đánh giá
    }

    public function rules(): array
    {
        return [
            'phone'         => ['required', 'regex:/^0[0-9]{9}$/', 'max:20'],
            'customer_name' => 'required|string|max:100',
            'content'       => 'required|string|max:1000',
            'rating'        => 'required|integer|min:1|max:5',
            'image'         => ['nullable', 'image', 'max:2048'],

        ];
    }

    public function messages(): array
    {
        return [
            'phone.required'         => 'Vui lòng nhập số điện thoại.',
            'phone.regex'            => 'Số điện thoại không đúng định dạng. Vui lòng nhập 10 chữ số và bắt đầu bằng số 0.',
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'content.required'       => 'Vui lòng nhập nội dung đánh giá.',
            'content.max'            => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
            'rating.required'        => 'Vui lòng chọn mức đánh giá.',
            'rating.integer'         => 'Mức đánh giá phải là số nguyên.',
            'rating.min'             => 'Mức đánh giá tối thiểu là 1 sao.',
            'rating.max'             => 'Mức đánh giá tối đa là 5 sao.',

        ];
    }
}
