<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandRequest extends FormRequest
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
            'client_id' => 'required|integer',
            'title' => 'required',
            'priority' => 'required',
            'sector' => 'required',
            'responsible' => 'required|',
            'who_should_test' => 'required|',
            'description' => 'required',
            'midia' => 'required',
            'customer_charged' => 'nullable|boolean',
            'estimated_time' => 'nullable|integer',
            'time_spent' => 'nullable|integer',
            'status' => 'nullable|string',
            'return' =>  'nullable|boolean',
            'is_deleted' => 'nullable|boolean'
        ];
    }
}
