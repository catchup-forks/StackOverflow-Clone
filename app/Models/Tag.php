<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    protected $table = 'tags';

    protected $guarded = [];

    public static array $rules = [];

    public function postTag(): BelongsTo
    {
        return $this->belongsTo(PostTag::class);
    }
}
