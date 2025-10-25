<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteType extends Model
{
    protected $table = 'vote_types';

    protected $guarded = [];

    public static array $rules = [];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
}
