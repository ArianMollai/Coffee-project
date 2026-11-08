<?php

namespace App\Http\Requests\Ingridient;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateIngridientRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:256', Rule::unique('ingridients')],
            'base_unit_id' => ['required', 'integer', 'exists:units,id'],
            'quantity' => ['nullable', 'numeric'],
            'low_stock_treshhold' => ['required', 'numeric']
        ];
    }
}
