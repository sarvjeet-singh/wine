<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqSectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'account_type' => 'required|string|max:255',
            'section_name' => 'required|string|max:255',
            'id' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];
    }

    // Automatically return JSON response when the request is an AJAX call
    public function wantsJson()
    {
        return true; // This forces validation to return JSON if it's an AJAX request
    }
}
