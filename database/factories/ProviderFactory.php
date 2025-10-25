<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'provider_name' => $this->faker->word(),
            'provider_uid' => $this->faker->randomNumber(),
        ];
    }
}
