<?php

namespace App\Services;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostService extends AbstractBaseService
{
    public function listQuestions(int $perPage = 15): LengthAwarePaginator
    {
        return Post::query()
            ->where('post_type_id', PostType::Question->value)
            ->orderByDesc('creation_date')
            ->with(['comments', 'votes', 'user'])
            ->paginate($perPage);
    }

    public function findQuestion(int $id): Post
    {
        return Post::query()
            ->where('post_type_id', PostType::Question->value)
            ->with(['comments', 'user'])
            ->findOrFail($id);
    }

    public function createQuestion(array $data, User $user): Post
    {
        $now = Carbon::now();
        $tagNames = $this->normalizeTagNames($data['tags'] ?? []);
        $post = Post::query()->create([
            'post_type_id' => PostType::Question->value,
            'creation_date' => $now,
            'score' => 0,
            'view_count' => 0,
            'body' => $data['body'],
            'user_id' => $user->id,
            'owner_display_name' => $user->display_name,
            'last_editor_user_id' => $user->id,
            'last_editor_display_name' => $user->display_name,
            'last_edit_date' => $now,
            'last_activity_date' => $now,
            'title' => $data['title'],
            'tags' => implode(',', $tagNames),
            'answer_count' => 0,
            'comment_count' => 0,
            'favorite_count' => 0,
            'is_blog' => $data['is_blog'] ?? false,
        ]);

        $this->syncTags($tagNames, true);
        $post->tags()->sync($this->ensureTagIds($tagNames));

        return $post;
    }

    public function updateQuestion(Post $post, array $data, User $user): Post
    {
        $tagNames = $this->normalizeTagNames($data['tags'] ?? []);

        $post->fill([
            'body' => $data['body'],
            'title' => $data['title'],
            'tags' => implode(',', $tagNames),
            'last_editor_user_id' => $user->id,
            'last_editor_display_name' => $user->display_name,
            'last_edit_date' => Carbon::now(),
            'is_blog' => $data['is_blog'] ?? $post->is_blog,
        ]);

        $post->save();

        $this->syncTags($tagNames);
        $post->tags()->sync($this->ensureTagIds($tagNames));

        return $post->refresh();
    }

    public function deleteQuestion(Post $post): void
    {
        Post::query()->where('parent_id', $post->id)->delete();
        $post->delete();
    }

    public function recentTags(): Collection
    {
        return Tag::query()->orderByDesc('count')->limit(10)->get();
    }

    public function adminUpdatePost(Post $post, array $data, User $admin): Post
    {
        if ($post->type() === PostType::Question) {
            return $this->updateQuestion($post, $data, $admin);
        }

        $post->fill([
            'body' => $data['body'],
            'title' => $data['title'] ?? $post->title,
            'is_blog' => $data['is_blog'] ?? $post->is_blog,
            'last_editor_user_id' => $admin->id,
            'last_editor_display_name' => $admin->display_name,
            'last_edit_date' => Carbon::now(),
            'last_activity_date' => Carbon::now(),
        ]);

        $post->save();

        return $post->refresh();
    }

    public function answersForQuestion(Post $question): Collection
    {
        return Post::query()
            ->where('parent_id', $question->id)
            ->where('post_type_id', PostType::Answer->value)
            ->orderByDesc('creation_date')
            ->get();
    }

    private function syncTags(array $tags, bool $increaseCount = false): void
    {
        foreach ($tags as $tagName) {
            $tag = Tag::query()->firstOrCreate(['name' => $tagName], ['count' => 0]);

            if ($increaseCount) {
                $tag->increment('count');
            }
        }
    }

    /**
     * @param  array<int, string>|string|null  $tags
     * @return array<int, string>
     */
    private function normalizeTagNames(array|string|null $tags): array
    {
        if (is_string($tags)) {
            $tags = explode(',', $tags);
        }

        if (! is_array($tags)) {
            return [];
        }

        $collection = collect($tags)
            ->map(fn ($tag) => trim((string) $tag))
            ->filter();

        $idStrings = $collection->filter(fn (string $tag) => ctype_digit($tag));
        $names = $collection->diff($idStrings)->map(fn (string $tag) => Str::lower($tag));

        if ($idStrings->isNotEmpty()) {
            $ids = $idStrings->map(fn (string $id) => (int) $id);
            $resolved = Tag::query()->whereIn('id', $ids)->pluck('name', 'id');

            if ($resolved->count() !== $ids->count()) {
                throw (new ModelNotFoundException())->setModel(Tag::class);
            }

            $names = $names->merge($resolved->map(fn (string $name) => Str::lower($name))->values());
        }

        return $names
            ->map(fn (string $tag) => Str::lower($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<int, string>  $tagNames
     * @return array<int, int>
     */
    private function ensureTagIds(array $tagNames): array
    {
        return collect($tagNames)
            ->map(fn (string $tag) => Tag::query()->firstOrCreate(['name' => $tag], ['count' => 0]))
            ->pluck('id')
            ->all();
    }

}
