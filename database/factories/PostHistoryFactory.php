<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostHistoryFactory extends Factory
{
    protected $model = PostHistory::class;

    public function definition(): array
    {
        return [
            'post_history_type_id' => 1,
            'post_id' => Post::factory(),
            'revision_GUID' => $this->faker->randomNumber(),
            'on_date' => Carbon::now(),
            'user_id' => User::factory(),
            'user_display_name' => $this->faker->name(),
            'comment' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
