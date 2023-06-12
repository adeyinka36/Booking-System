<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserUpdateRequest extends FormRequest
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
            'first_name' => 'sometimes|required|max:255',
            'last_name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|max:255',
            'phone_number' => 'sometimes|required|numeric',
            'is_admin' => 'sometimes|required|boolean'
        ];
    }
}
