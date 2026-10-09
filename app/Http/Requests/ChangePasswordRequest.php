<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Pašreizējā parole ir obligāta.',
            'current_password.current_password' => 'Pašreizējā parole nav pareiza.',

            'password.required' => 'Jaunā parole ir obligāta.',
            'password.min' => 'Jaunajai parolei jābūt vismaz 8 rakstzīmes garai.',
            'password.max' => 'Jaunā parole nedrīkst pārsniegt 255 rakstzīmes.',
            'password.confirmed' => 'Paroles apstiprinājums nesakrīt ar jauno paroli.',
        ];
    }
}
