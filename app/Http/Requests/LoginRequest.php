<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class LoginRequest extends FormRequest
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
            'credential' => ['required', 'string', function($attribute, $value, $fail){
                $isEmail= filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                $isPhone= preg_match('/^(09\d{9}|\+98\d{9})$/', $value) === 1;

                if(!$isEmail && !$isPhone){
                    $fail('the '.$attribute. ' must be a valid email or phone number');
                }
            },
        ],
            'password' => ['required', 'min:6']
        ];
    }
}
