<?php
namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:10|unique:members,phone',
            'email'        => 'required|email|max:100|unique:members,email',
            'notes'        => 'nullable|string',
            'rfid_card_id' => 'nullable|string|max:50|unique:members,rfid_card_id',
            'img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
    /**
     * Get the custom validation messages for the defined rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên của hội viên.',
            'full_name.max'      => 'Họ và tên không được vượt quá 100 ký tự.',

            'phone.required'     => 'Số điện thoại là bắt buộc.',
            'phone.unique'       => 'Số điện thoại này đã được sử dụng.',

            'email.required'     => 'Địa chỉ email là bắt buộc.',
            'email.email'        => 'Địa chỉ email không hợp lệ.',
            'email.unique'       => 'Email này đã được đăng ký cho một tài khoản khác.',

            'img.image'          => 'File tải lên phải là một hình ảnh.',
            'img.mimes'          => 'Chỉ chấp nhận các định dạng ảnh: jpg, jpeg, png.',
            'img.max'            => 'Kích thước ảnh không được vượt quá 2MB.',
        ];
    }
}
