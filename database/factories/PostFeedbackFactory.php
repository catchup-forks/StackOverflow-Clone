<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostFeedback;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFeedbackFactory extends Factory
{
    protected $model = PostFeedback::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'is_anonymous' => $this->faker->boolean(),
            'vote_type_id' => 1,
            'creation_date' => Carbon::now(),
        ];
    }
}
