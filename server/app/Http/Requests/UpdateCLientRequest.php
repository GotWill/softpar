<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCLientRequest extends FormRequest
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
        $clientId = $this->route()->parameter('client');
        return [
            "name" => "required",
            "email" => "required|email|unique:clients,email,{$clientId}",
            'whatsapp' => "nullable|string",
            "warning_email" => "nullable|boolean",
            "warning_whatsapp" => "nullable|boolean",
            "observation" => "nullable|string",
        ];
    }
}
