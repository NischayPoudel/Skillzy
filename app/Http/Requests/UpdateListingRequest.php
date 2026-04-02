<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->id === $this->route('listing')->user_id;
    }

    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:1|max:10000',
            'experience_level' => 'required|in:beginner,intermediate,expert',
            'status' => 'required|in:active,inactive',
        ];
    }
}
