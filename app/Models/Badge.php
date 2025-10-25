<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Badge extends Model
{
    protected $table = 'badges';

    protected $guarded = [];

    public static array $rules = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
