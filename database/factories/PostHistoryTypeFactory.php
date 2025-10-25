<?php

namespace Database\Factories;

use App\Models\PostHistoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostHistoryTypeFactory extends Factory
{
    protected $model = PostHistoryType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
