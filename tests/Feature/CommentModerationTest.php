<?php

namespace Tests\Feature;

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
        // Arrange
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => 1]);
        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => false,
        ]);

        // Act
        $response = $this->actingAs($user)->post(route('comments.flag', $comment));

        // Assert
        $response->assertRedirect();
        $this->assertTrue($comment->fresh()->requires_admin_review);
    }

    #[Test]
    public function it_allows_admins_to_update_comments(): void
    {
        // Arrange
        \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $question = Post::factory()->create(['post_type_id' => 1]);
        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => true,
        ]);

        // Act
        $response = $this->actingAs($admin)->patch(route('comments.adminUpdate', $comment), [
            'post_id' => $question->id,
            'body' => 'Edited by admin.',
        ]);

        // Assert
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'Edited by admin.',
            'requires_admin_review' => false,
        ]);
    }
}
