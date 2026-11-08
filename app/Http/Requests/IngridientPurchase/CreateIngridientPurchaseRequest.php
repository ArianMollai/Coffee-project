<?php

namespace App\Http\Requests\IngridientPurchase;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateIngridientPurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ingridient_id' => $this->route('ingridient_id')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ingridient_id' => ['required', 'exists:ingridients,id'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'quantity' => ['numeric'],
        ];
    }
}
