<?php

namespace Database\Factories;

use App\Models\VoteType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteTypeFactory extends Factory
{
    protected $model = VoteType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
