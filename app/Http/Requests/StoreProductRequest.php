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
            'stock' => ['required', 'integer'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'category_id.required' => 'El campo categoría es obligatorio',
            'category_id.exists' => 'La categoría seleccionada no existe',
            'name.required' => 'El campo nombre es obligatorio',
            'description.required' => 'El campo descripción es obligatorio',
            'price.required' => 'El campo precio es obligatorio',
            'price.integer' => 'El campo precio debe ser un número entero',
            'stock.required' => 'El campo stock es obligatorio',
            'stock.integer' => 'El campo stock debe ser un número entero',
            'image.required' => 'El campo imagen es obligatorio',
            'image.image' => 'El campo imagen debe ser una imagen',
            'image.mimes' => 'El campo imagen debe ser un archivo de tipo: jpeg, png, jpg, gif, svg',
            'image.max' => 'El campo imagen no debe pesar más de 2MB',
        ];
    }
}
