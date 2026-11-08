<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateAttributeRequest extends FormRequest
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
        $id=$this->route('id');

        return [
            'name' => ['required', 'string', Rule::unique('attributes')->ignore($id)],
            'is_color' => ['boolean'],
/*             'values' => ['required', 'array', 'min:1'],
            'values.*.value' => ['required', 'string'],
            'value.*.color_code' => [
                Rule::requiredIf(fn() => $this->boolean('is_color')),
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ] */
        ];
    }
}
