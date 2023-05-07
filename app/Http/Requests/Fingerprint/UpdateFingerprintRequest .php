<?php

namespace App\Http\Requests\Fingerprint;

use Illuminate\Foundation\Http\FormRequest;

class CreateFingerprintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'serial_number' => 'required|string',
            'is_active' => 'required|string',
            
        ];
    }

    public function messages()
    {
        return [
            'start.required' => 'The start date field is required',
            'end.required' => 'The end date field is required'
        ];
    }
}
