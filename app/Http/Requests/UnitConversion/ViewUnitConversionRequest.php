<?php

namespace App\Http\Requests\UnitConversion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ViewUnitConversionRequest extends FormRequest
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
            'from_unit_id' => ['required', 'integer', 'exists:units,id'],
            'to_unit_id' => ['required', 'integer', 'exists:units,id']
        ];
    }
}
