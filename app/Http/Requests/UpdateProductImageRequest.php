<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
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
            'image' => ['required', 'file'],
            'product_id' => ['required', 'integer', 'exists:products,id']
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'A nova foto do produto é obrigatória.',
            'image.file' => 'A nova foto do produto deve ser uma imagem.',
            'product_id.required' => 'O campo de ID do produto é obrigatório.',
            'product_id.integer' => 'O campo de ID do produto deve ser um número.',
            'product_id.exists' => 'O campo de ID do produto deve corresponder à algum produto.',
        ];
    }
}
