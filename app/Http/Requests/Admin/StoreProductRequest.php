<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Normalise a typed slug ("My Product" -> "my-product")
        if ($this->filled('slug')) {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug', // auto-generated from name when empty
            'price'       => 'required|numeric|min:0|max:99999999',
            'tag'         => 'nullable|string|max:100',
            'description' => 'nullable|string|max:5000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'status'      => 'required|boolean',
        ];
    }
}
