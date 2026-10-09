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
        'Username.required' => 'Lietotājvārds ir obligāts.',
        'Username.max' => 'Lietotājvārds nedrīkst pārsniegt 255 rakstzīmes.',
        'Username.unique' => 'Šāds lietotājvārds jau eksistē.',

        'email.required' => 'E-pasta adrese ir obligāta.',
        'email.email' => 'Lūdzu, ievadiet derīgu e-pasta adresi.',
        'email.unique' => 'Šī e-pasta adrese jau tiek izmantota.',

        'password.required' => 'Parole ir obligāta.',
        'password.min' => 'Parolei jābūt vismaz 8 rakstzīmes garai.',
        'password.max' => 'Parole nedrīkst pārsniegt 255 rakstzīmes.',
    ];
}
}