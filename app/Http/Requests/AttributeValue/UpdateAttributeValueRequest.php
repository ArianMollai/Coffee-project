<?php

namespace App\Http\Requests\AttributeValue;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Attribute;
use Illuminate\Validation\Rule;

class UpdateAttributeValueRequest extends FormRequest
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
            "attribute_id" => $this->route('attribute_id') 
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isColorAttribute=Attribute::find($this->route('attribute_id'))?->is_color;
        if($isColorAttribute===1) $isColorAttribute=true;

        return [
            'attribute_id' => ['required', 'exists:attributes,id'],
            'value' => ['required', 'string'],
            'color_code' => [
                Rule::requiredIf($isColorAttribute),
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ]
        ];
    }
}
