<?php

return [
    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'before' => 'The :attribute must be a date before :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'email' => 'The :attribute format is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'integer' => 'The :attribute must be an integer.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute must be a string.',
    'unique' => 'The :attribute has already been taken.',
    'url' => 'The :attribute format is invalid.',

    'custom' => [
        'answer' => [
            'question_id.required' => 'Select a question to answer.',
            'body.required' => 'Share the details of your answer.',
        ],
        'question' => [
            'title.required' => 'Questions need a clear title.',
            'body.required' => 'Describe the full problem.',
            'tags.required' => 'Choose at least one tag.',
        ],
        'comment' => [
            'post_id.required' => 'Comments must belong to a post.',
            'body.required' => 'Write something before submitting.',
        ],
        'tag' => [
            'name.required' => 'Tags require a name.',
            'count.required' => 'Provide an initial usage count.',
        ],
        'user' => [
            'display_name.required' => 'Enter the user display name.',
            'email.required' => 'Enter an email address.',
        ],
        'password' => [
            'current_password.required' => 'Confirm your existing password.',
            'password.required' => 'Provide a new password.',
        ],
        'profile' => [
            'bio.string' => 'The biography must be valid text.',
        ],
    ],

    'attributes' => [
        'question_id' => 'question',
        'body' => 'content',
        'title' => 'title',
    ],
];
