<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TagService extends AbstractBaseService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Tag::query()->orderByDesc('count')->paginate($perPage);
    }

    public function create(array $data): Tag
    {
        return Tag::query()->create($data);
    }

    public function update(Tag $tag, array $data): Tag
    {
        $tag->fill($data);
        $tag->save();

        return $tag->refresh();
    }

    public function delete(Tag $tag): void
    {
        $tag->delete();
    }
}
