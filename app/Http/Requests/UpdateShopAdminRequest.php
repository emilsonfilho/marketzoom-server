<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopAdminRequest extends FormRequest
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
            'new_admin_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'new_admin_id.required' => 'O novo administrador da loja é obrigatório.',
            'new_admin_id.integer' => 'O novo administrador da loja deve ser um número.',
            'new_admin_id.exists' => 'O novo administrador da loja não foi encontrado.',
        ];
    }
}
