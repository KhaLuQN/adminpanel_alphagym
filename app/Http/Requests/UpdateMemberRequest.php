<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
        $memberId = $this->input('member_id');

        return [
            'member_id'    => 'required|exists:members,member_id',
            'full_name'    => 'required|string|max:100',
            'phone'        => ['required', 'string', 'max:15', Rule::unique('members')->ignore($memberId, 'member_id')],
            'email'        => ['nullable', 'email', 'max:100', Rule::unique('members')->ignore($memberId, 'member_id')],
            'notes'        => 'nullable|string',
            'img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rfid_card_id' => ['nullable', 'string', 'max:50', Rule::unique('members')->ignore($memberId, 'member_id')],
            'status'       => ['required', 'string', Rule::in(['active', 'expired', 'banned'])],
        ];
    }
}
