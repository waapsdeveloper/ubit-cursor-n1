<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidderApplicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string|max:20',
            'cnic' => 'required|string|max:15',
            'deposit_amount' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:100',
            'payment_proof' => 'nullable|string',
            'status' => 'required|in:pending,payment_verified,invitation_sent,approved,rejected',
            'admin_notes' => 'nullable|string',
        ];
    }
}
