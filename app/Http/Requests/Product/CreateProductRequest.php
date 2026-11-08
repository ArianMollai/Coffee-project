<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:256', Rule::unique('products')],
            'description' => ['nullable', 'string'],

            'categories' => ['required', 'exists:categories,id'],

            'prices' => ['required', 'array', 'min:1'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
            'prices.*.discount' => ['sometimes', 'numeric', 'min:0', 'lte:100'],
            'prices.*.inventory' => ['required', 'integer', 'min:0'],

            'prices.*.ingridients' => ['required', 'array'],
            'prices.*.ingridients.*.ingridient_id' => ['required', 'integer', 'exists:ingridients,id'],
            'prices.*.ingridients.*.volume' => ['required', 'numeric', 'gt:0'],
            'prices.*.ingridients.*.unit_id' => ['required', 'integer', 'exists:units,id'],

            'prices.*.attribute_value_ids' => ['required', 'array', 'min:1'],
            'prices.*.attribute_value_ids.*' => ['integer', 'exists:attribute_value,id'],

            'images' => ['sometimes', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'primary_image_index' => ['sometimes', 'nullable', 'integer', 'min:0', 'required_with:images']
        ];
    }
}
