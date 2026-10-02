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
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'User ID must exist in the users table.',
            'date_from.required' => 'Start date is required.',
            'date_from.date' => 'Start date must be a valid date.',
            'date_till.required' => 'End date is required.',
            'date_till.date' => 'End date must be a valid date.',
            'date_till.after' => 'End date must be after the start date.',
            'budget.numeric' => 'Budget must be a number.',
            'budget.min' => 'Budget cannot be negative.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either unvisited or visited.',
            'category.in' => 'Category must be one of: rest, nature, adventure.',
            'image.file' => 'Image must be a valid file.',
            'image.mimes' => 'Image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'Image cannot exceed 2048 kilobytes.'
        ];
    }
}
