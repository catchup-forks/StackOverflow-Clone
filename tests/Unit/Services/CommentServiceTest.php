<?php

namespace Tests\Unit\Services;

use App\Services\CommentService;
use App\Enums\PostType;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(CommentService::class)]
class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_comment(): void
    {
        /** @Arrange */
        $service = new CommentService();
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $comment = $service->create([
            'post_id' => $question->id,
            'body' => 'A thoughtful comment.',
        ], $user);

        /** @Assert */
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'body' => 'A thoughtful comment.']);
    }

    #[Test]
    public function it_updates_a_comment(): void
    {
        /** @Arrange */
        $service = new CommentService();
        $comment = Comment::factory()->create();

        /** @Act */
        $updated = $service->update($comment, ['body' => 'Updated']);

        /** @Assert */
        $this->assertEquals('Updated', $updated->body);
    }

    #[Test]
    public function it_flags_a_comment_for_admin_review(): void
    {
        /** @Arrange */
        $service = new CommentService();
        $comment = Comment::factory()->create(['requires_admin_review' => false]);

        /** @Act */
        $flagged = $service->flagForAdmin($comment);

        /** @Assert */
        $this->assertTrue($flagged->requires_admin_review);
    }

    #[Test]
    public function it_allows_admins_to_update_comments(): void
    {
        /** @Arrange */
        $service = new CommentService();
        $comment = Comment::factory()->create(['requires_admin_review' => true]);
        $admin = User::factory()->create();

        /** @Act */
        $updated = $service->adminUpdate($comment, ['body' => 'Reviewed'], $admin);

        /** @Assert */
        $this->assertFalse($updated->requires_admin_review);
        $this->assertEquals('Reviewed', $updated->body);
    }

    #[Test]
    public function it_throws_when_comment_post_is_missing(): void
    {
        /** @Arrange */
        $service = new CommentService();
        $user = User::factory()->create();

        /** @Assert */
        $this->expectException(ModelNotFoundException::class);

        /** @Act */
        $service->create([
            'post_id' => 999,
            'body' => 'Attempted comment.',
        ], $user);
    }
}
