<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqQuestionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question' => 'required|array',
            'question.*' => 'required|string|min:1', // Each question must be a non-empty string
            'answer' => 'required|array',
            'answer.*' => 'required|string|min:1', // Each answer must be a non-empty string
            'question_id' => 'nullable|array',
            'question_id.*' => 'nullable|integer',
            // 'answer' => 'size:question', // Ensure both arrays are of equal length
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'Questions are required.',
            'question.array' => 'Questions must be an array.',
            'question.*.required' => 'Each question cannot be empty.',
            'question.*.string' => 'Each question must be a string.',
            'answer.required' => 'Answers are required.',
            'answer.array' => 'Answers must be an array.',
            'answer.*.required' => 'Each answer cannot be empty.',
            'answer.*.string' => 'Each answer must be a string.',
        ];
    }

    // Automatically return JSON response when the request is an AJAX call
    public function wantsJson()
    {
        return true; // This forces validation to return JSON if it's an AJAX request
    }
}
