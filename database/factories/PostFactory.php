<?php

namespace Database\Factories;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $now = Carbon::now();

        return [
            'post_type_id' => PostType::Question->value,
            'accepted_answer_id' => null,
            'parent_id' => null,
            'creation_date' => $now,
            'score' => $this->faker->numberBetween(0, 100),
            'view_count' => $this->faker->numberBetween(0, 1000),
            'body' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(),
            'owner_display_name' => $this->faker->name(),
            'last_editor_user_id' => null,
            'last_editor_display_name' => null,
            'last_edit_date' => $now,
            'last_activity_date' => $now,
            'title' => $this->faker->sentence(),
            'tags' => implode(',', $this->faker->words(3)),
            'answer_count' => 0,
            'comment_count' => 0,
            'favorite_count' => 0,
            'is_blog' => false,
        ];
    }
}
