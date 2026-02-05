<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDemandRequest extends FormRequest
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
            'title' => 'nullable|string',
            'priority' => 'nullable|string',
            'sector' => 'nullable|string',
            'responsible' => 'nullable|string',
            'who_should_test' => 'nullable|string',
            'description' => 'nullable|string',
            'midia' => 'nullable|string',
            'customer_charged' => 'nullable|boolean',
            'estimated_time' => 'nullable|integer',
            'time_spent' => 'nullable|integer',
            'status' => 'nullable|string',
            'return' =>  'nullable|boolean',
        ];
    }
}
