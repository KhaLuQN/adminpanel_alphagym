<?php
namespace App\Http\Requests;

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
            'phone'        => 'required|string|max:15|unique:members,phone',
            'email'        => 'required|email|max:100|unique:members,email',
            'notes'        => 'nullable|string',
            'rfid_card_id' => 'nullable|string|max:50|unique:members,rfid_card_id',
            'img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
