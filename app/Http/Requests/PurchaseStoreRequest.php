<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PurchaseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_skill_id' => 'required|exists:user_skills,id',
            'note' => 'nullable|string|max:1000',
            'transaction_pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]+$/', $this->transactionPinVerification()],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'transaction_pin.required' => 'Transaction PIN is required.',
            'transaction_pin.size' => 'Transaction PIN must be exactly 4 digits.',
            'transaction_pin.regex' => 'Transaction PIN must contain only numbers.',
            'transaction_pin.transaction_pin_verification' => 'Invalid Transaction PIN.',
        ];
    }

    /**
     * Custom validation rule to verify transaction PIN.
     */
    protected function transactionPinVerification()
    {
        return function ($attribute, $value, $fail) {
            $user = Auth::user();
            if (!Hash::check($value, $user->transaction_pin)) {
                $fail('Invalid Transaction PIN.');
            }
        };
    }

    public function userSkill()
    {
        return \App\Models\UserSkill::findOrFail($this->user_skill_id);
    }
}
