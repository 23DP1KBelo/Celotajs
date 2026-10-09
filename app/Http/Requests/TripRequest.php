<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'date_from' => 'required|date',
            'date_till' => 'required|date|after:date_from',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:unvisited, visited',
            'category' => 'nullable|string|in:rest,nature,adventure',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Ceļojuma nosaukums ir obligāts.',
            'title.max' => 'Ceļojuma nosaukums nedrīkst pārsniegt 255 rakstzīmes.',

            'user_id.required' => 'Lietotāja ID ir obligāts.',
            'user_id.exists' => 'Norādītajam lietotāja ID ir jābūt reģistrētam lietotāju tabulā.',

            'date_from.required' => 'Ceļojuma sākuma datums ir obligāts.',
            'date_from.date' => 'Ceļojuma sākuma datumam jābūt derīgam datumam.',

            'date_till.required' => 'Ceļojuma beigu datums ir obligāts.',
            'date_till.date' => 'Ceļojuma beigu datumam jābūt derīgam datumam.',
            'date_till.after' => 'Ceļojuma beigu datumam jābūt vēlākam par sākuma datumu.',

            'budget.numeric' => 'Budžetam jābūt skaitlim.',
            'budget.min' => 'Budžets nedrīkst būt negatīvs.',

            'status.required' => 'Statuss ir obligāts.',
            'status.in' => 'Statusam jābūt vienai no šīm vērtībām: neapmeklēts vai apmeklēts.',

            'category.in' => 'Kategorijai jābūt vienai no šīm vērtībām: atpūta, daba vai piedzīvojumi.',

            'image.file' => 'Attēlam jābūt derīgam failam.',
            'image.mimes' => 'Attēlam jābūt JPG, JPEG vai PNG formātā.',
            'image.max' => 'Attēla izmērs nedrīkst pārsniegt 2048 kilobaitus.',
        ];
    }
}