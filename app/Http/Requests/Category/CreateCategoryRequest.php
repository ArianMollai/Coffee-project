<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
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
        $categoryId=$this->route('id');

        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('categories')],
            'parent_id' => ['nullable', Rule::exists('categories', 'id'), Rule::notIn([$categoryId])]
        ];
    }
}
