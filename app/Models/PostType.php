<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostType extends Model
{
    protected $table = 'post_types';

    protected $guarded = [];

    public static array $rules = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
