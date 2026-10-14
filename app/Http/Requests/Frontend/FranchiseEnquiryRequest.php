<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class FranchiseEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:150'],
            'phone'           => ['required', 'string', 'min:10', 'max:30'],
            'email'           => ['nullable', 'email', 'max:150'],
            'city'            => ['required', 'string', 'max:150'],
            'budget'          => ['nullable', 'string', 'max:150'],
            'property_status' => ['nullable', 'string', 'max:150'],
            'notes'           => ['nullable', 'string', 'max:2000'],
        ];
    }
    protected function getRedirectUrl()
{
    return route('frontend.franchise') . '#enquiry';
}
}