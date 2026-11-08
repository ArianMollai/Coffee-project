<?php

namespace App\Http\Requests\Extra;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExtraRequest extends FormRequest
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
        $extra_id=$this->route('extra_id');

        return [
            'name' => ['required', 'string', 'max:256', Rule::unique('extras')->ignore($extra_id)],
            'price' => ['required', 'numeric']
        ];
    }
}
