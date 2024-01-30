<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título do comentário deve ser uma string.',
            'content.required' => 'O conteúdo do comentário é obrigatório.',
            'content.string' => 'O conteúdo do comentário deve ser uma string.',
            'rating.required' => 'O campo de classificação é obrigatório.',
            'rating.integer' => 'O campo de classificação deve ser um número.',
            'rating.min' => 'O mínimo de uma classificação é zero.',
            'rating.max' => 'O máximo de uma classificação é cinco.',
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.integer' => 'O ID do usuário é um número.',
            'user_id.exists' => 'Usuário não encontrado ou inexistente.',
            'product_id.required' => 'O ID do produto é obrigatório.',
            'product_id.integer' => 'O ID do produto é um número.',
            'product_id.exists' => 'Produto não encontrado ou inexistente.',
        ];
    }
}
