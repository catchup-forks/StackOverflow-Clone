<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostHistoryType extends Model
{
    protected $table = 'post_history_type';

    protected $guarded = [];

    public static array $rules = [];

    public function postHistory(): BelongsTo
    {
        return $this->belongsTo(PostHistory::class);
    }
}
