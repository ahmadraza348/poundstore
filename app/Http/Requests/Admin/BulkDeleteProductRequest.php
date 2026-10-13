<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_ids' => 'required|string',
        ];
    }

    public function getProductIds(): array
    {
        return array_filter(array_map('intval', explode(',', $this->product_ids)));
    }
}
