<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentUpvote;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class CommentService
{
    public function paginateForPost(Post $post, int $perPage = 20): LengthAwarePaginator
    {
        return Comment::query()
            ->where('post_id', $post->id)
            ->orderByDesc('creation_date')
            ->paginate($perPage);
    }

    public function create(array $data, User $user): Comment
    {
        $now = Carbon::now();

        $comment = Comment::query()->create([
            'post_id' => $data['post_id'],
            'score' => 0,
            'body' => $data['body'],
            'creation_date' => $now,
            'user_display_name' => $user->display_name,
            'user_id' => $user->id,
            'requires_admin_review' => $data['requires_admin_review'] ?? false,
        ]);

        Post::query()->whereKey($data['post_id'])->increment('comment_count');
        Post::query()->whereKey($data['post_id'])->update(['last_activity_date' => Carbon::now()]);

        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->fill([
            'body' => $data['body'],
            'requires_admin_review' => $data['requires_admin_review'] ?? $comment->requires_admin_review,
        ]);

        $comment->save();

        return $comment->refresh();
    }

    public function flagForAdmin(Comment $comment): Comment
    {
        $comment->requires_admin_review = true;
        $comment->save();

        return $comment->refresh();
    }

    public function adminUpdate(Comment $comment, array $data, User $admin): Comment
    {
        $comment->fill([
            'body' => $data['body'],
            'requires_admin_review' => false,
            'admin_editor_id' => $admin->id,
        ]);

        $comment->save();

        return $comment->refresh();
    }

    public function upvote(Comment $comment, User $user): void
    {
        CommentUpvote::query()->firstOrCreate([
            'comment_id' => $comment->id,
            'user_id' => $user->id,
        ]);

        $comment->increment('score');
    }
}
