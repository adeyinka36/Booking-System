<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|string,exists:users,id',
            'vehicle_make' => 'sometimes|required|max:255',
            'vehicle_model' => 'sometimes|required|max:255',
            'booking_date' => 'sometimes|required|date',
            'booking_time' => 'sometimes|required|string',
        ];
    }
}
