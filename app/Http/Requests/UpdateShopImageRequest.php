<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopImageRequest extends FormRequest
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
            'profile' => ['required', 'file']
        ];
    }

    public function messages()
    {
        return [
            'profile.required' => 'O campo de perfil é obrigatório.',
            'profile.file' => 'O campo de foto deve ser um arquivo de perfil.',
        ];
    }
}
