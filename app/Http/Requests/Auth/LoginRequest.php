<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|max:20|min:8',
        ];
    }
}
