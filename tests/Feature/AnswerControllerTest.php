<?php

namespace Tests\Feature;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_an_answer(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->actingAs($user)->post(route('answer.store'), [
            'question_id' => $question->id,
            'body' => 'This is a thorough response.',
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('posts', [
            'parent_id' => $question->id,
            'body' => 'This is a thorough response.',
        ]);
    }
}
