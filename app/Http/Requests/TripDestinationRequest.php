<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TripDestinations extends FormRequest
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
            'recommendations' => 'required|boolean',
            'trip_id' => 'required|exists:trips,id',
            'destination_id' => 'required|exists:destinations,id',
        ];
    }
    


    public function messages(): array
    {
        return [
            'recommendations.required' => 'Ieteikumu lauks ir obligāts.',
            'recommendations.boolean' => 'Ieteikumu laukam jābūt loģiskai vērtībai (true vai false).',
            'trip_id.required' => 'Ceļojuma ID ir obligāts.',
            'trip_id.exists' => 'Norādītajam ceļojuma ID ir jābūt reģistrētam ceļojumu tabulā.',
            'destination_id.required' => 'Galamērķa ID ir obligāts.',
            'destination_id.exists' => 'Norādītajam galamērķa ID ir jābūt reģistrētam galamērķu tabulā.',
        ];
    }
}
