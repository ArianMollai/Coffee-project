<?php

namespace App\Http\Requests\UnitConversion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitConversionRequest extends FormRequest
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
        $unitConversion_id=$this->route('unitconversion_id');

        return [
            'from_unit_id' => ['required', 'integer', 'exists:units,id', Rule::unique('unit_conversion')->ignore('unitconversion_id')],
            'to_unit_id' => ['required', 'integer', 'exists:units,id', Rule::unique('unit_conversion')->ignore('unitconversion_id')],
            'multiplier' => ['required', 'numeric']
        ];
    }
}
