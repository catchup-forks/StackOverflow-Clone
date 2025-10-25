<?php

namespace Database\Factories;

use App\Models\SuggestEditVote;
use App\Models\SuggestedEdit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SuggestEditVoteFactory extends Factory
{
    protected $model = SuggestEditVote::class;

    public function definition(): array
    {
        return [
            'suggested_edit_id' => SuggestedEdit::factory(),
            'user_id' => User::factory(),
            'vote_type_id' => 1,
            'creation_date' => Carbon::now(),
        ];
    }
}
