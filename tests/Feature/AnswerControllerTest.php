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

    #[Test]
    public function it_lists_answers_as_html(): void
    {
        /** @Arrange */
        Post::factory()->count(2)->create(['post_type_id' => PostType::Answer->value]);

        /** @Act */
        $response = $this->get(route('answer.index'));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.answer.index');
    }

    #[Test]
    public function it_lists_answers_as_json(): void
    {
        /** @Arrange */
        Post::factory()->count(2)->create(['post_type_id' => PostType::Answer->value]);

        /** @Act */
        $response = $this->getJson(route('answer.index'));

        /** @Assert */
        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    #[Test]
    public function it_shows_an_answer_by_redirecting_to_question(): void
    {
        /** @Arrange */
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $response = $this->get(route('answer.show', $answer));

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
    }

    #[Test]
    public function it_redirects_to_questions_index_when_answer_has_no_parent(): void
    {
        /** @Arrange */
        $answer = Post::factory()->create(['post_type_id' => PostType::Answer->value, 'parent_id' => null]);

        /** @Act */
        $response = $this->get(route('answer.show', $answer));

        /** @Assert */
        $response->assertRedirect(route('questions.index'));
    }

    #[Test]
    public function it_shows_an_answer_as_json(): void
    {
        /** @Arrange */
        $answer = Post::factory()->create(['post_type_id' => PostType::Answer->value]);

        /** @Act */
        $response = $this->getJson(route('answer.show', $answer));

        /** @Assert */
        $response->assertOk();
        $response->assertJson(['id' => $answer->id]);
    }

    #[Test]
    public function it_renders_the_edit_view_for_an_answer(): void
    {
        /** @Arrange */
        $answer = Post::factory()->create(['post_type_id' => PostType::Answer->value]);

        /** @Act */
        $response = $this->get(route('answer.edit', $answer));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.answer.edit');
    }

    #[Test]
    public function it_updates_an_answer(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'user_id' => $user->id,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $response = $this->actingAs($user)->patch(route('answer.update', $answer), [
            'body' => 'Updated answer body',
            'is_blog' => true,
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('posts', [
            'id' => $answer->id,
            'body' => 'Updated answer body',
            'is_blog' => true,
        ]);
    }

    #[Test]
    public function it_requires_a_body_when_updating_an_answer(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'user_id' => $user->id,
        ]);

        /** @Act */
        $response = $this->from(route('answer.edit', $answer))
            ->actingAs($user)
            ->patch(route('answer.update', $answer), [
                'body' => '',
            ]);

        /** @Assert */
        $response->assertRedirect(route('answer.edit', $answer));
        $response->assertSessionHasErrors(['body']);
    }

    #[Test]
    public function it_deletes_an_answer(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);
        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
        ]);

        /** @Act */
        $response = $this->actingAs($user)->delete(route('answer.destroy', $answer));

        /** @Assert */
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseMissing('posts', ['id' => $answer->id]);
    }

    #[Test]
    public function it_requires_a_valid_question_when_creating(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->from(route('question.index'))->actingAs($user)->post(route('answer.store'), [
            'question_id' => 999,
            'body' => 'Body',
        ]);

        /** @Assert */
        $response->assertRedirect(route('question.index'));
        $response->assertSessionHasErrors(['question_id']);
    }

    #[Test]
    public function it_requires_a_body_when_creating(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->from(route('question.show', $question))
            ->actingAs($user)
            ->post(route('answer.store'), [
                'question_id' => $question->id,
                'body' => '',
            ]);

        /** @Assert */
        $response->assertRedirect(route('question.show', $question));
        $response->assertSessionHasErrors(['body']);
    }
}
