<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostHistory extends Model
{
    protected $table = 'post_history';

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

    public function postHistoryType(): HasOne
    {
        return $this->hasOne(PostHistoryType::class, 'post_history_type_id');
    }
}
