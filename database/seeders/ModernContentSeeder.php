<?php

namespace Database\Seeders;

use App\Enums\PostType;
use App\Models\Comment;
use App\Models\CommentUpvote;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ModernContentSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect(['admin', 'user']);
        $roles->each(fn (string $role) => \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => $role,
            'guard_name' => 'web',
        ]));

        $users = User::factory(8)->create();
        $admins = collect([
            User::factory()->create(['display_name' => 'Admin One']),
            User::factory()->create(['display_name' => 'Admin Two']),
        ]);
        $allUsers = $users->merge($admins);

        $allUsers->each(function (User $user): void {
            $user->profile()->create([
                'bio' => 'Community member',
                'location' => 'Remote',
                'website_url' => 'https://example.com',
            ]);

            $user->assignRole('user');
        });

        $admins->each(fn (User $admin) => $admin->assignRole('admin'));

        $tags = Tag::factory(10)->create();

        $questions = Post::factory(10)->create()->each(function (Post $post) use ($tags, $allUsers): void {
            $author = $allUsers->random();
            $post->update([
                'user_id' => $author->id,
                'owner_display_name' => $author->display_name,
                'tags' => $tags->random(3)->pluck('name')->implode(','),
                'is_blog' => (bool) random_int(0, 1),
            ]);
        });

        $questions->take(5)->each(function (Post $question) use ($allUsers): void {
            $responder = $allUsers->random();
            $answer = Post::factory()->create([
                'post_type_id' => PostType::Answer->value,
                'parent_id' => $question->id,
                'title' => null,
                'is_blog' => false,
                'user_id' => $responder->id,
                'owner_display_name' => $responder->display_name,
            ]);

            $question->update([
                'accepted_answer_id' => $answer->id,
                'answer_count' => $question->answer_count + 1,
            ]);
        });

        $comments = new Collection();

        foreach ($questions as $question) {
            $postComments = Comment::factory(20)->make(['post_id' => $question->id])->each(function (Comment $comment) use ($allUsers): void {
                $author = $allUsers->random();
                $comment->user_id = $author->id;
                $comment->user_display_name = $author->display_name;
                $comment->save();
            });

            $comments = $comments->merge($postComments);
            $question->update(['comment_count' => $postComments->count()]);
        }

        $comments->take(5)->each(fn (Comment $comment) => $comment->update(['requires_admin_review' => true]));

        $voters = $allUsers->shuffle();
        $comments->take(20)->each(function (Comment $comment, int $index) use ($voters): void {
            $user = $voters[$index % $voters->count()];
            CommentUpvote::factory()->create([
                'comment_id' => $comment->id,
                'user_id' => $user->id,
            ]);
            $comment->increment('score');
        });
    }
}
