<?php

namespace Tests\Feature\Filament\Admin;

use App\Filament\Admin\Resources\CommentResource\Pages\ListComments;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListComments::class)]
class CommentResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_comments_via_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $author = User::factory()->create(['display_name' => 'Helpful Commenter']);
        $moderator = User::factory()->create(['display_name' => 'Moderator']);

        Livewire::test(ListComments::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $author->id,
                'user_display_name' => 'Override Name',
                'score' => 3,
                'body' => '<p>Great clarification on the issue.</p>',
                'requires_admin_review' => true,
                'admin_editor_id' => $moderator->id,
                'creation_date' => Carbon::parse('2024-02-01 08:00')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $author->id,
            'body' => '<p>Great clarification on the issue.</p>',
            'requires_admin_review' => true,
        ]);
    }

    #[Test]
    public function admin_can_update_comments_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $comment = Comment::factory()->create([
            'body' => '<p>Initial body</p>',
            'requires_admin_review' => false,
        ]);

        $moderator = User::factory()->create();

        Livewire::test(ListComments::class)
            ->callTableAction('edit', $comment->getKey(), data: [
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'user_display_name' => $comment->user_display_name,
                'score' => 7,
                'body' => '<p>Updated comment body</p>',
                'requires_admin_review' => true,
                'admin_editor_id' => $moderator->id,
                'creation_date' => Carbon::parse('2024-03-10 14:45')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $comment->refresh();

        $this->assertSame('<p>Updated comment body</p>', $comment->body);
        $this->assertTrue($comment->requires_admin_review);
        $this->assertSame($moderator->id, $comment->admin_editor_id);
    }

    #[Test]
    public function admin_can_delete_comments_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $comment = Comment::factory()->create();

        Livewire::test(ListComments::class)
            ->callTableAction('delete', $comment->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    #[Test]
    public function comment_body_is_required_when_creating(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $author = User::factory()->create();

        Livewire::test(ListComments::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $author->id,
                'body' => '',
            ])
            ->assertHasActionErrors(['body']);
    }
}
