<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
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
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|string|max:55|unique:users',
            'password' => 'required|max:20|min:8',
            'confirm_password' => 'required_with:password|same:password|max:20|min:8',
        ];
    }
}
