<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $table = 'posts';

    protected $guarded = [];

    public static array $rules = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function postType(): HasOne
    {
        return $this->hasOne(PostType::class);
    }

    public function postHistory(): HasOne
    {
        return $this->hasOne(PostHistory::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function postTags(): HasMany
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'post_id');
    }

    public function postFeedback(): HasMany
    {
        return $this->hasMany(PostFeedback::class, 'post_id');
    }

    public function suggestedEdits(): HasMany
    {
        return $this->hasMany(SuggestedEdit::class, 'post_id');
    }
}
