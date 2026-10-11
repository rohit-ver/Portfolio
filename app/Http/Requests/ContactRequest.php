<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'min:3', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your full name so Rohit can address you properly.',
            'name.min' => 'Your name must contain at least 2 characters.',
            'email.required' => 'A valid email address is required so we can reply back to you.',
            'email.email' => 'Please enter a valid, deliverable email address.',
            'subject.required' => 'Please provide a subject line for your inquiry.',
            'subject.min' => 'Subject line should be at least 3 characters long.',
            'message.required' => 'Please describe your project, inquiry, or idea in the message box.',
            'message.min' => 'Your message should be at least 10 characters long to provide sufficient context.',
        ];
    }
}
