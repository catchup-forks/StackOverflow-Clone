<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'vote_type_id' => 1,
            'user_id' => User::factory(),
            'creation_date' => Carbon::now(),
            'bounty_amount' => $this->faker->numberBetween(0, 100),
        ];
    }
}
