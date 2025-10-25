<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BaseModelObserver
{
    public function creating(Model $model): void
    {
        $this->ensureTimestamps($model);
    }

    public function updating(Model $model): void
    {
        $this->touchUpdatedAt($model);
    }

    protected function ensureTimestamps(Model $model): void
    {
        $now = Carbon::now();
        $createdColumn = $model->getCreatedAtColumn();

        if ($createdColumn && empty($model->{$createdColumn})) {
            $model->{$createdColumn} = $now;
        }

        $this->touchUpdatedAt($model);
    }

    protected function touchUpdatedAt(Model $model): void
    {
        $column = $model->getUpdatedAtColumn();
        if ($column) {
            $model->{$column} = Carbon::now();
        }
    }
}
