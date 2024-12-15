<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'added_by' => 'nullable|string'
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
