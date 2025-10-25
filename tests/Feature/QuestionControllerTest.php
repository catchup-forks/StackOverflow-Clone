<?php

namespace Tests\Feature;

use App\Enums\PostType;
use App\Models\Post;
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
        /** @Arrange */
        $user = User::factory()->create();
        $tags = Tag::factory(2)->create();

        /** @Act */
        $response = $this->actingAs($user)->post(route('question.store'), [
            'title' => 'How do I upgrade Laravel?',
            'body' => 'Looking for migration strategies.',
            'tags' => $tags->pluck('id')->all(),
            'is_blog' => false,
        ]);

        /** @Assert */
        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'How do I upgrade Laravel?',
            'post_type_id' => PostType::Question->value,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function it_updates_a_question(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original title',
            'body' => 'Original body',
        ]);
        $tags = Tag::factory(2)->create();

        /** @Act */
        $response = $this->actingAs($user)->patch(route('question.update', $question), [
            'title' => 'Updated title',
            'body' => 'Updated body',
            'tags' => $tags->pluck('id')->all(),
            'is_blog' => true,
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('posts', [
            'id' => $question->id,
            'title' => 'Updated title',
            'body' => 'Updated body',
            'is_blog' => true,
        ]);
    }

    #[Test]
    public function it_deletes_a_question(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['user_id' => $user->id]);

        /** @Act */
        $response = $this->actingAs($user)->delete(route('question.destroy', $question));

        /** @Assert */
        $response->assertRedirect(route('questions.index'));
        $this->assertDatabaseMissing('posts', ['id' => $question->id]);
    }

    #[Test]
    public function it_requires_at_least_one_tag_when_creating(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->from(route('question.create'))->actingAs($user)->post(route('question.store'), [
            'title' => 'Validation title',
            'body' => 'Validation body',
            'tags' => [],
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.create'));
        $response->assertSessionHasErrors(['tags']);
        $this->assertDatabaseCount('posts', 0);
    }

    #[Test]
    public function it_requires_existing_tags(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->actingAs($user)->post(route('question.store'), [
            'title' => 'Invalid tags',
            'body' => 'Some body',
            'tags' => [999],
        ]);

        /** @Assert */
        $response->assertRedirect();
        $response->assertSessionHasErrors(['tags.0']);
        $this->assertDatabaseCount('posts', 0);
    }
}
