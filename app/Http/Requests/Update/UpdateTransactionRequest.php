<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'wallet_id' => 'required|exists:wallets,id',
            'related_wallet_id' => 'nullable|exists:wallets,id',
            'reference' => 'required|string|unique:transactions,reference',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'processed_at' => 'nullable|date',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array {
        return [
            'wallet_id.required' => 'The wallet ID is required.',
            'wallet_id.exists' => 'The selected wallet does not exist.',
            'related_wallet_id.exists' => 'The related wallet does not exist.',
            'reference.required' => 'A reference is required.',
            'reference.unique' => 'The reference must be unique.',
            'type.required' => 'The transaction type is required.',
            'type.in' => 'The transaction type must be either credit or debit.',
            'amount.required' => 'The transaction amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be at least 0.01.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'processed_at.date' => 'The processed at field must be a valid date.',
        ];
    }
}
