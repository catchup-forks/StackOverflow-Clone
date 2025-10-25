<?php

namespace Tests\Unit\Services;

use App\Services\AnswerService;
use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(AnswerService::class)]
class AnswerServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_an_answer_and_updates_question_counts(): void
    {
        /** @Arrange */
        $service = new AnswerService();
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $service->create([
            'question_id' => $question->id,
            'body' => 'An insightful answer.',
        ], $user);

        /** @Assert */
        $this->assertDatabaseHas('posts', [
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);
        $this->assertSame(1, $question->fresh()->answer_count);
    }

    #[Test]
    public function it_updates_an_answer_body(): void
    {
        /** @Arrange */
        $service = new AnswerService();
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $updated = $service->update($answer, ['body' => 'Updated body'], $user);

        /** @Assert */
        $this->assertEquals('Updated body', $updated->body);
    }

    #[Test]
    public function it_deletes_an_answer_and_decrements_question_count(): void
    {
        /** @Arrange */
        $service = new AnswerService();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value, 'answer_count' => 1]);
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $service->delete($answer);

        /** @Assert */
        $this->assertDatabaseMissing('posts', ['id' => $answer->id]);
        $this->assertSame(0, $question->fresh()->answer_count);
    }

    #[Test]
    public function it_throws_when_creating_for_missing_question(): void
    {
        /** @Arrange */
        $service = new AnswerService();
        $user = User::factory()->create();

        /** @Assert */
        $this->expectException(ModelNotFoundException::class);

        /** @Act */
        $service->create([
            'question_id' => 999,
            'body' => 'Attempted answer.',
        ], $user);
    }
}
