<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostTag extends Model
{
    protected $table = 'post_tags';

    protected $guarded = [];

    public static array $rules = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function tag(): HasOne
    {
        return $this->hasOne(Tag::class, 'tag_id');
    }
}
