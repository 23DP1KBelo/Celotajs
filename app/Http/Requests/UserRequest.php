<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Username' => 'required|string|max:255|unique:users,Username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
{
    return [
        'Username.required' => 'Username is required.',
        'Username.max' => 'Username must not exceed 255 characters.',
        'Username.unique' => 'This username already exists.',

        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already in use.',

        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters long.',
        'password.max' => 'Password must not exceed 255 characters.',
    ];
}
}