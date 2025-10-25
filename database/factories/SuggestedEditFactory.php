<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\SuggestedEdit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SuggestedEditFactory extends Factory
{
    protected $model = SuggestedEdit::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'creation_date' => Carbon::now(),
            'approval_date' => null,
            'rejection_date' => null,
            'owner_user_id' => User::factory(),
            'comment' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'title' => $this->faker->sentence(),
            'tags' => implode(',', $this->faker->words(3)),
            'revision_GUID' => $this->faker->randomNumber(),
        ];
    }
}
