<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'title'          => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'experience'     => ['required', 'integer', 'min:0'],
            'bio'            => ['required', 'string'],
            'profile_image'  => ['nullable', 'url'],
        ];
    }
}