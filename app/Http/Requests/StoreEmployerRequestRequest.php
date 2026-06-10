<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name'   => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email'],
            'request_type'   => ['required', 'in:internship,hiring,corporate_training,ai_workshop'],
            'message'        => ['required', 'string'],
        ];
    }
}