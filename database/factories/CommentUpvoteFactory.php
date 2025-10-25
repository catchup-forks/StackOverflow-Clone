<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CommentUpvote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentUpvoteFactory extends Factory
{
    protected $model = CommentUpvote::class;

    public function definition(): array
    {
        return [
            'comment_id' => Comment::factory(),
            'user_id' => User::factory(),
        ];
    }
}
