<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'icon_type' => ['required', 'in:class,image'],
            'icon_class' => ['nullable', 'string', 'max:150', 'required_if:icon_type,class'],
            'icon_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:1024'], // Max 1MB
            'proficiency' => ['nullable', 'integer', 'between:0,100'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
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
            'name.required' => 'The skill name is required.',
            'icon_class.required_if' => 'Please provide an icon CSS class (e.g., bi bi-fire) when icon type is class.',
            'icon_image_file.max' => 'The skill icon image may not be greater than 1 MB.',
            'proficiency.between' => 'Proficiency percentage must be between 0 and 100.',
        ];
    }
}
