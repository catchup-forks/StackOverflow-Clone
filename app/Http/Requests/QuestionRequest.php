<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:250'],
            'body' => ['required', 'string'],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['string', 'max:25'],
            'is_blog' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.custom.question');
    }
}
