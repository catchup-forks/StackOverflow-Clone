<?php

namespace App\Services;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class AnswerService extends AbstractBaseService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Post::query()
            ->where('post_type_id', PostType::Answer->value)
            ->orderByDesc('creation_date')
            ->with(['user', 'votes'])
            ->paginate($perPage);
    }

    public function find(int $id): Post
    {
        return Post::query()
            ->where('post_type_id', PostType::Answer->value)
            ->with(['user', 'votes'])
            ->findOrFail($id);
    }

    public function create(array $data, User $user): Post
    {
        $question = Post::query()
            ->where('post_type_id', PostType::Question->value)
            ->findOrFail($data['question_id']);

        $now = Carbon::now();

        $answer = Post::query()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
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
            'title' => '',
            'tags' => '',
            'answer_count' => 0,
            'comment_count' => 0,
            'favorite_count' => 0,
            'is_blog' => $data['is_blog'] ?? false,
        ]);

        $this->incrementQuestionAnswerCount($question);

        return $answer;
    }

    public function update(Post $answer, array $data, User $user): Post
    {
        $answer->fill([
            'body' => $data['body'],
            'last_editor_user_id' => $user->id,
            'last_editor_display_name' => $user->display_name,
            'last_edit_date' => Carbon::now(),
            'last_activity_date' => Carbon::now(),
            'is_blog' => $data['is_blog'] ?? $answer->is_blog,
        ]);

        $answer->save();

        return $answer->refresh();
    }

    public function delete(Post $answer): void
    {
        $parentId = $answer->parent_id;
        $answer->delete();

        if ($parentId) {
            $question = Post::query()
                ->where('post_type_id', PostType::Question->value)
                ->find($parentId);

            if ($question) {
                $this->decrementQuestionAnswerCount($question);
            }
        }
    }

    private function incrementQuestionAnswerCount(Post $question): void
    {
        $question->increment('answer_count');
        $question->forceFill(['last_activity_date' => Carbon::now()])->save();
    }

    private function decrementQuestionAnswerCount(Post $question): void
    {
        if ($question->answer_count > 0) {
            $question->decrement('answer_count');
        }

        $question->forceFill(['last_activity_date' => Carbon::now()])->save();
    }
}
