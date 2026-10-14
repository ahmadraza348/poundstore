<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:150'],
            'contact' => ['required', 'string', 'max:150'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ];
    }
    protected function getRedirectUrl()
{
    return route('frontend.contact') . '#contact-form';
}
}