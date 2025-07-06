<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize()
    {return true;}

    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'img'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_date' => 'required|date',
            'status'        => 'required|in:working,maintenance,broken',
            'location'      => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ];
    }
    /**
     * Báo lỗi tiếng viẹt.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'          => 'Vui lòng nhập tên thiết bị.',
            'name.string'            => 'Tên thiết bị phải là một chuỗi ký tự.',
            'name.max'               => 'Tên thiết bị không được vượt quá 255 ký tự.',

            'img.image'              => 'File tải lên phải là một hình ảnh.',
            'img.mimes'              => 'Chỉ chấp nhận các định dạng ảnh: jpg, jpeg, png, gif.',
            'img.max'                => 'Kích thước ảnh không được vượt quá 2MB.',

            'purchase_date.required' => 'Vui lòng chọn ngày mua thiết bị.',
            'purchase_date.date'     => 'Ngày mua phải là một ngày hợp lệ.',

            'status.required'        => 'Vui lòng chọn trạng thái của thiết bị.',
            'status.in'              => 'Trạng thái được chọn không hợp lệ.',

            'location.max'           => 'Vị trí không được vượt quá 255 ký tự.',
        ];
    }
}
