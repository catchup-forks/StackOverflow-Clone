<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:25'],
            'count' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.custom.tag');
    }
}
