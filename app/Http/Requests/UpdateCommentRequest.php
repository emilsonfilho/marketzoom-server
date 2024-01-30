<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'title' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título do comentário deve ser uma string.',
            'content.required' => 'O conteúdo do comentário é obrigatório.',
            'content.string' => 'O conteúdo do comentário deve ser uma string.',
            'rating.required' => 'A classificação é obrigatória.',
            'rating.integer' => 'A classificação deve ser um número',
            'rating.min' => 'A classificação mínima é zero.',
            'rating.max' => 'A classificação máxima é cinco.',
        ];
    }
}
