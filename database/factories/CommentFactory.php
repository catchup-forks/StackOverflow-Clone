<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'score' => $this->faker->numberBetween(0, 50),
            'body' => $this->faker->sentence(),
            'creation_date' => Carbon::now(),
            'user_display_name' => $this->faker->name(),
            'user_id' => User::factory(),
            'requires_admin_review' => false,
        ];
    }
}
