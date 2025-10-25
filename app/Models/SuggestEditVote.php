<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuggestEditVote extends Model
{
    protected $table = 'SuggestEditVotes';

    protected $guarded = [];

    public static array $rules = [];

    public function suggestedEdit(): BelongsTo
    {
        return $this->belongsTo(SuggestedEdit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
