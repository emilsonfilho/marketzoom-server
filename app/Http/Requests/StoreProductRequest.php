<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'price' => ['required', 'integer'],
            'stock_quantity' => ['required', 'integer', 'gt:0'],
            'details' => ['required', 'string'],
            'image' => ['required', 'file'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'price.required' => 'O campo de preço é obrigatório.',
            'price.integer' => 'O campo de preço deve ser um número.',
            'stock_quantity.required' => 'A quantidade disponível em estoque é obrigatória.',
            'stock_quantity.integer' => 'A quantidade disponível em estoque deve ser um número.',
            'stock_quantity.gt' => 'A quantidade disponível em estoque deve ser maior que zero.',
            'details.required' => 'A descrição do prduto é obrigatória.',
            'details.string' => 'A descrição do produto deve ser uma string.',
            'image.required' => 'A foto do produto é obrigatória.',
            'image.file' => 'A foto do produto deve ser uma imagem.',
            'user_id.required' => 'O ID do dono do produto é obrigatório.',
            'user_id.integer' => 'O ID do dono do produto deve ser um número.',
            'user_id.exists' => 'O dono do produto não existe.',
        ];
    }
}
