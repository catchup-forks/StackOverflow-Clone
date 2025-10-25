<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? null;

        return [
            'display_name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email,' . $userId],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string'],
            'reputation' => ['sometimes', 'integer', 'min:0'],
            'views' => ['sometimes', 'integer', 'min:0'],
            'up_votes' => ['sometimes', 'integer', 'min:0'],
            'down_votes' => ['sometimes', 'integer', 'min:0'],
            'age' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.custom.user');
    }
}
