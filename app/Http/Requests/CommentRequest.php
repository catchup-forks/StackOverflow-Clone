<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postRule = $this->isMethod('post')
            ? ['required', 'integer', 'exists:posts,id']
            : ['sometimes', 'integer', 'exists:posts,id'];

        return [
            'post_id' => $postRule,
            'body' => ['required', 'string'],
            'requires_admin_review' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.custom.comment');
    }
}
