<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'slogan' => ['required', 'string'],
            'icon' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'slogan.require' => 'O campo de slogan é obrigatório.',
            'slogan.string' => 'O campo de slogan deve ser uma string',
            'icon.required' => 'O campo de ícone é obrigatório.',
            'icon.integer' => 'O campo de ícone deve ser um número.',
        ];
    }
}
