<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'count' => $this->faker->numberBetween(0, 1000),
            'excerpt_post_id' => null,
            'wiki_post_id' => null,
        ];
    }
}
