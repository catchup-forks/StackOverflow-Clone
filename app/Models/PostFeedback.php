<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostFeedback extends Model
{
    protected $table = 'post_feedback';

    protected $guarded = [];

    public static array $rules = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function voteType(): HasOne
    {
        return $this->hasOne(PostType::class, 'post_type_id');
    }
}
