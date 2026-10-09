<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'name' => 'required|max:255',
            'country_code' => 'required|max:2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nosaukums ir obligāts.',
            'name.max' => 'Nosaukums nedrīkst pārsniegt 255 rakstzīmes.',
            'country_code.required' => 'Valsts kods ir obligāts.',
            'country_code.max' => 'Valsts kods nedrīkst pārsniegt 2 rakstzīmes.',
        ];
    }
}
