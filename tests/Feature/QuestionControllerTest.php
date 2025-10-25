<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_question_with_tags(): void
    {
        // Arrange
        $user = User::factory()->create();
        $tags = Tag::factory(2)->create();

        // Act
        $response = $this->actingAs($user)->post(route('question.store'), [
            'title' => 'How do I upgrade Laravel?',
            'body' => 'Looking for migration strategies.',
            'tags' => $tags->pluck('id')->all(),
            'is_blog' => false,
        ]);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'How do I upgrade Laravel?',
            'post_type_id' => 1,
            'user_id' => $user->id,
        ]);
    }
}
