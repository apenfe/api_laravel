<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest {
    public function rules(): array {
        return [
            'content' => 'required|string|min:5|max:255',
        ];
    }

    public function authorize(): bool {
        return true;
    }

    protected function prepareForValidation() {
        $this->merge([
            'product_id' => $this->route('product'),
        ]);
    }
}
