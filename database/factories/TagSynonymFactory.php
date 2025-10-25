<?php

namespace Database\Factories;

use App\Models\TagSynonym;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TagSynonymFactory extends Factory
{
    protected $model = TagSynonym::class;

    public function definition(): array
    {
        return [
            'source_tag_name' => $this->faker->word(),
            'target_tag_name' => $this->faker->word(),
            'creation_date' => Carbon::now(),
            'user_id' => User::factory(),
            'auto_rename_count' => 0,
            'last_auto_rename' => Carbon::now(),
            'score' => 0,
            'approved_by_user_id' => User::factory(),
            'approval_date' => Carbon::now(),
        ];
    }
}
