<?php

namespace App\Http\Requests\Table;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTableRequest extends FormRequest
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
            "number" => ['required', 'integer', Rule::unique('tables')],
            "capacity" => ['required', 'integer'],
            "place" => ['required', 'string'],
            "is_vip" => ["boolean"],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['required', 'numeric', 'min:0', 'lte:price'],
        ];
    }
}
