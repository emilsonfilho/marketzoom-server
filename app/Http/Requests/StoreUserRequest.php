<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'profile' => ['nullable', 'file']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string',
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um email válido.',
            'password.required' => 'O campo de senha deve ser obrigatório',
            'password.string' => 'O campo de senha deve ser uma string.',
            'password.regex' => 'O campo de senha deve conter letras maiúsculas e minúsculas e pelo menos um número e deve ter entre 8 e 36 caracteres.',
            'profile.file' => 'O campo de perfil deve ser um arquivo de imagem.',
        ];
    }
}
