<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

trait BelongsToFranchise
{
    public static function bootBelongsToFranchise(): void
    {
        static::creating(function ($model): void {
            if (isset($model->franchise_id) && empty($model->franchise_id)) {
                $model->franchise_id = Config::get('app.default_franchise_id', 1);
            }
        });
    }

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Franchise::class);
    }
}
