<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    public function rules(): array
    {
        return [
            'listing_id' => 'required|exists:user_skills,id',
            'note' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'listing_id.required' => 'Please select a listing',
            'listing_id.exists' => 'Selected listing does not exist',
        ];
    }
}
