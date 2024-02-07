<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutItemRequest extends FormRequest
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
            'quantity' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'O campo de quantidade é obrigatório.',
            'quantity.integer' => 'O campo de quantidade deve ser um número.'
        ];
    }
}
