<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'display_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'creation_date' => $this->faker->dateTime(),
            'last_access_date' => $this->faker->dateTime(),
            'reputation' => $this->faker->numberBetween(0, 10000),
            'views' => $this->faker->numberBetween(0, 1000),
            'up_votes' => $this->faker->numberBetween(0, 500),
            'down_votes' => $this->faker->numberBetween(0, 500),
            'remember_token' => Str::random(10),
        ];
    }
}
