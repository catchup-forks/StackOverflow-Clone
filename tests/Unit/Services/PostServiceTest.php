<?php

namespace Tests\Unit\Services;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_question_with_tags(): void
    {
        /** @Arrange */
        $service = new PostService();
        $user = User::factory()->create();
        $tags = Tag::factory(2)->create();

        /** @Act */
        $post = $service->createQuestion([
            'title' => 'How to test services?',
            'body' => 'Looking for best practices.',
            'tags' => $tags->pluck('id')->all(),
        ], $user);

        /** @Assert */
        $this->assertEquals(PostType::Question->value, $post->post_type_id);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'How to test services?']);
    }

    #[Test]
    public function it_updates_a_question(): void
    {
        /** @Arrange */
        $service = new PostService();
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $tags = Tag::factory(2)->create();

        /** @Act */
        $updated = $service->updateQuestion($question, [
            'title' => 'Updated title',
            'body' => 'Updated body',
            'tags' => $tags->pluck('id')->all(),
        ], $user);

        /** @Assert */
        $this->assertEquals('Updated title', $updated->title);
        $this->assertDatabaseHas('posts', ['id' => $question->id, 'title' => 'Updated title']);
    }

    #[Test]
    public function it_deletes_a_question_and_answers(): void
    {
        /** @Arrange */
        $service = new PostService();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        Post::factory()->count(2)->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $service->deleteQuestion($question);

        /** @Assert */
        $this->assertDatabaseMissing('posts', ['id' => $question->id]);
        $this->assertDatabaseCount('posts', 0);
    }
}
