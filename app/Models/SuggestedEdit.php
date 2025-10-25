<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuggestedEdit extends Model
{
    protected $table = 'suggested_edits';

    protected $guarded = [];

    public static array $rules = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function suggestedEditVotes(): HasMany
    {
        return $this->hasMany(SuggestedEditVote::class, 'suggested_edit_id');
    }
}
