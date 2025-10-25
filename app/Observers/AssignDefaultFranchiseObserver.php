<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class AssignDefaultFranchiseObserver
{
    public function creating(Model $model): void
    {
        $column = $this->detectFranchiseColumn($model);
        if (! $column) {
            return;
        }

        if (! $model->getAttribute($column)) {
            $model->setAttribute($column, config('app.default_franchise', 'global'));
        }
    }

    private function detectFranchiseColumn(Model $model): ?string
    {
        $fillable = method_exists($model, 'getFillable') ? $model->getFillable() : [];

        foreach (['franchise_id', 'franchise'] as $column) {
            if (in_array($column, $fillable, true)) {
                return $column;
            }
        }

        return null;
    }
}
