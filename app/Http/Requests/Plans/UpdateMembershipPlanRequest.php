<?php
namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'description'      => 'nullable|string',
            'is_active'        => 'boolean',
            'features'         => 'nullable|array',
            'features.*.id'    => 'nullable|exists:plan_features,feature_id',
            'features.*.value' => 'nullable|string|max:255',

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
            'required'      => 'Trường :attribute là bắt buộc.',
            'required_with' => 'Trường :attribute là bắt buộc khi có quyền lợi được chọn.',
            'numeric'       => 'Trường :attribute phải là số.',
            'integer'       => 'Trường :attribute phải là số nguyên.',
            'min'           => [
                'numeric' => 'Trường :attribute phải có giá trị tối thiểu là :min.',
            ],
            'max'           => [
                'numeric' => 'Trường :attribute không được lớn hơn :max.',
            ],
            'string'        => 'Trường :attribute phải là chuỗi.',
            'boolean'       => 'Trường :attribute phải là true hoặc false.',
            'exists'        => 'Giá trị được chọn cho :attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'plan_name'        => 'tên gói tập',
            'duration_days'    => 'thời hạn',
            'price'            => 'giá gốc',
            'discount_percent' => 'giảm giá',
            'description'      => 'mô tả',
            'is_active'        => 'trạng thái',
            'features.*.id'    => 'quyền lợi',
            'features.*.value' => 'giá trị quyền lợi',
        ];
    }
}
