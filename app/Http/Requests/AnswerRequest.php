<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $questionRule = $this->isMethod('post')
            ? ['required', 'integer', 'exists:posts,id']
            : ['sometimes', 'integer', 'exists:posts,id'];

        return [
            'question_id' => $questionRule,
            'body' => ['required', 'string'],
            'is_blog' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.custom.answer');
    }
}
