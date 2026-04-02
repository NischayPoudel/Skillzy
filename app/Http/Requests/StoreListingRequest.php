<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    public function rules(): array
    {
        return [
            'skill_id' => 'required|exists:skills,id',
            'price' => 'required|numeric|min:1|max:10000',
            'experience_level' => 'required|in:beginner,intermediate,expert',
        ];
    }

    public function messages(): array
    {
        return [
            'skill_id.required' => 'Please select a skill',
            'skill_id.exists' => 'Selected skill does not exist',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 1 coin',
            'experience_level.required' => 'Experience level is required',
        ];
    }
}
