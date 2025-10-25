<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuggestedEditVote extends Model
{
    protected $table = 'suggested_edit_votes';

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
