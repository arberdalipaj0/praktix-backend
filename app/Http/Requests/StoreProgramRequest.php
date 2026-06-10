<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                => ['required', 'string', 'max:255'],
            'category'             => ['required', 'string', 'max:100'],
            'description'          => ['required', 'string'],
            'duration'             => ['required', 'string', 'max:100'],
            'price'                => ['required', 'numeric', 'min:0'],
            'image_url'            => ['nullable', 'url'],
            'expert_id'            => ['required', 'exists:experts,id'],
            'certificate_included' => ['boolean'],
        ];
    }
}