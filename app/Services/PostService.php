<?php

namespace App\Services;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

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
        $tagNames = Tag::query()->whereIn('id', $data['tags'])->pluck('name')->all();
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

        return $post;
    }

    public function updateQuestion(Post $post, array $data, User $user): Post
    {
        $tagNames = Tag::query()->whereIn('id', $data['tags'])->pluck('name')->all();

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

}
