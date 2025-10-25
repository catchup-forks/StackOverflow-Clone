<?php

namespace Tests\Feature;

use App\Enums\PostType;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommentModerationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_flags_a_comment_for_admin_review(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => false,
        ]);

        /** @Act */
        $response = $this->actingAs($user)->post(route('comments.flag', $comment));

        /** @Assert */
        $response->assertRedirect();
        $this->assertTrue($comment->fresh()->requires_admin_review);
    }

    #[Test]
    public function it_creates_a_comment(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->actingAs($user)->post(route('comments.store'), [
            'post_id' => $question->id,
            'body' => 'A helpful comment.',
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('comments', [
            'post_id' => $question->id,
            'body' => 'A helpful comment.',
        ]);
    }

    #[Test]
    public function it_requires_a_body_when_creating_a_comment(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->from(route('question.show', $question))
            ->actingAs($user)
            ->post(route('comments.store'), [
                'post_id' => $question->id,
                'body' => '',
            ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', $question));
        $response->assertSessionHasErrors(['body']);
    }

    #[Test]
    public function it_updates_a_comment(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        /** @Act */
        $response = $this->actingAs($user)->patch(route('comments.update', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Updated comment body',
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $comment->post_id]));
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment body',
        ]);
    }

    #[Test]
    public function it_requires_a_body_when_updating_a_comment(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        /** @Act */
        $response = $this->from(route('question.show', ['question' => $comment->post_id]))
            ->actingAs($user)
            ->patch(route('comments.update', $comment), [
                'post_id' => $comment->post_id,
                'body' => '',
            ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $comment->post_id]));
        $response->assertSessionHasErrors(['body']);
    }

    #[Test]
    public function it_allows_admins_to_update_comments(): void
    {
        /** @Arrange */
        \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => true,
        ]);

        /** @Act */
        $response = $this->actingAs($admin)->patch(route('comments.adminUpdate', $comment), [
            'post_id' => $question->id,
            'body' => 'Edited by admin.',
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'Edited by admin.',
            'requires_admin_review' => false,
        ]);
    }

    #[Test]
    public function it_forbids_non_admins_from_admin_update(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['requires_admin_review' => true]);

        /** @Act */
        $response = $this->actingAs($user)->patch(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Attempted edit',
        ]);

        /** @Assert */
        $response->assertForbidden();
    }
}
