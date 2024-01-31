<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyUserRequest extends FormRequest
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
            'next_admin_shop_id' => ['nullable', 'integer', 'exists:users,id']
        ];
    }

    public function messages(): array
    {
        return [
            'next_admin_shop_id.integer' => 'O ID do próximo dono da loja deve ser um número.',
            'next_admin_shop_id.exists' => 'Próximo dono da loja não encontrado.',
        ];
    }
}
