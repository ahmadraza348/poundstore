<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreOutletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : null,
            'branch_code' => $this->filled('branch_code') ? trim($this->input('branch_code')) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180', 'unique:outlets,slug'],
            'branch_code' => ['nullable', 'string', 'max:60', 'unique:outlets,branch_code'],
            'outlet_type' => ['required', 'in:retail_store,warehouse,head_office'],
            'area' => ['nullable', 'string', 'max:180'],
            'address' => ['required', 'string', 'max:2000'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_if:location_verified,1'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_if:location_verified,1'],
            'maps_url' => ['nullable', 'url', 'regex:~^https?://~i', 'max:2048'],
            'location_verified' => ['nullable', 'boolean'],
            'opening_hours' => ['nullable', 'array'],
            'opening_hours.*.closed' => ['nullable', 'boolean'],
            'opening_hours.*.open' => ['nullable', 'date_format:H:i', 'required_with:opening_hours.*.close'],
            'opening_hours.*.close' => ['nullable', 'date_format:H:i', 'required_with:opening_hours.*.open'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
        ];
    }
}
