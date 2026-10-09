<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'places_id' => 'required|exists:places,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nosaukums ir obligāts.',
            'title.max' => 'Nosaukums nedrīkst pārsniegt 255 rakstzīmes.',
            'places_id.required' => 'Vietas ID ir obligāts.',
            'places_id.exists' => 'Norādītajam vietas ID ir jābūt reģistrētam vietu tabulā.',
        ];
    }
}
