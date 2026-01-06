<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            // ======================
            // DATA PRODUK
            // ======================
            'category_id'     => ['required', 'exists:categories,id'],

            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],

            'price'           => ['required', 'numeric', 'min:1000'],

            // discount_price harus < price
            'discount_price'  => ['nullable', 'numeric', 'min:0', 'lt:price'],

            'stock'           => ['required', 'integer', 'min:0'],
            'weight'          => ['required', 'integer', 'min:1'],

            'is_active'       => ['boolean'],
            'is_featured'     => ['boolean'],

            // ======================
            // GAMBAR BARU (OPTIONAL)
            // ======================
            'images'          => ['nullable', 'array', 'max:10'],
            'images.*'        => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB
            ],

            // ======================
            // HAPUS GAMBAR LAMA
            // ======================
            'delete_images'   => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:product_images,id'],

            // ======================
            // SET PRIMARY IMAGE
            // ======================
            'primary_image'   => ['nullable', 'integer', 'exists:product_images,id'],
        ];
    }
}
