<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest {
    public function rules(): array {

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'integer'],
        ];

    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
