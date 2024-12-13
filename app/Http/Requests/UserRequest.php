<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
