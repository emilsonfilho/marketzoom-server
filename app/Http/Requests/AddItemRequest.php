<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
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
            'product_quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'product_quantity.required' => 'O campo de quantidade do produto é obrigatório.',
            'product_quantity.integer' => 'O campo de quantidade do produto deve ser um número.',
            'product_quantity.min' => 'O campo de quantidade do produto deve ser um ou superior.',
        ];
    }
}
