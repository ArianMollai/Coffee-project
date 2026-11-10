<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReservation extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id', 'min:0'],
            'table_id' => ['required', 'integer', 'exists:tables,id', 'min:0'],
            'starts_at' => ['required', 'date-format:Y-m-d H:i:s', 'after:now'],
            'ends_at' => ['required', 'date-format:Y-m-d H:i:s', 'after:starts_at'],
        ];
    }
}
