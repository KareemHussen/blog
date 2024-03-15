<?php

namespace App\Http\Requests\Auth;

use App\Http\Controllers\AuthController;
use App\Rules\MinMaxWordsRule;
use App\Rules\PhoneValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required', 'string' , new MinMaxWordsRule(1, 3)],
            'password' => 'required|string|confirmed|min:8|max:25',
            'email' => 'required|email|unique:users',
        ];
    }
}
