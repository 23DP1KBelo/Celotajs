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
            'recommendations.required' => 'Recommendations is required.',
            'recommendations.boolean' => 'Recommendations must be a boolean value.',
            'trip_id.required' => 'Trip ID is required.',
            'trip_id.exists' => 'Trip ID must exist in the trips table.',
            'destination_id.required' => 'Destination ID is required.',
            'destination_id.exists' => 'Destination ID must exist in the destinations table.',
        ];
    }
}
