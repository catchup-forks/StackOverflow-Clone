<?php

namespace Database\Factories;

use App\Models\SuggestedEdit;
use App\Models\SuggestedEditVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SuggestedEditVoteFactory extends Factory
{
    protected $model = SuggestedEditVote::class;

    public function definition(): array
    {
        return [
            'suggested_edit_id' => SuggestedEdit::factory(),
            'user_id' => User::factory(),
            'vote_type_id' => 1,
            'creation_date' => Carbon::now(),
            'target_user_id' => User::factory(),
            'target_rep_change' => $this->faker->numberBetween(-10, 10),
        ];
    }
}
