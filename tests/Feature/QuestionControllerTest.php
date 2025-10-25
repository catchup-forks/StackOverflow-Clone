<?php

namespace Tests\Feature;

use App\Filament\User\Resources\QuestionResource;
use App\Http\Controllers\QuestionController;
use App\Enums\PostType;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(QuestionController::class)]
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

        $questionId = Post::query()->where('title', 'How do I upgrade Laravel?')->value('id');

        /** @Assert */
        $this->assertNotNull($questionId);
        $response->assertRedirect(QuestionResource::getUrl('view', ['record' => $questionId]));
        $this->assertDatabaseHas('posts', [
            'title' => 'How do I upgrade Laravel?',
            'post_type_id' => PostType::Question->value,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function it_lists_questions_as_html(): void
    {
        /** @Arrange */
        Post::factory()->count(3)->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->get(route('question.index'));

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl());
    }

    #[Test]
    public function it_lists_questions_as_json(): void
    {
        /** @Arrange */
        Post::factory()->count(2)->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->getJson(route('question.index'));

        /** @Assert */
        $response->assertJsonStructure(['data']);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['post_type_id' => PostType::Question->value]);
    }

    #[Test]
    public function it_renders_the_create_form(): void
    {
        /** @Arrange */
        Tag::factory()->count(3)->create();

        /** @Act */
        $response = $this->actingAs(User::factory()->create())->get(route('question.create'));

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl('create'));
    }

    #[Test]
    public function it_shows_a_question(): void
    {
        /** @Arrange */
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->get(route('question.show', $question));

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl('view', ['record' => $question->getKey()]));
    }

    #[Test]
    public function it_shows_a_question_as_json(): void
    {
        /** @Arrange */
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->getJson(route('question.show', $question));

        /** @Assert */
        $response->assertJson(['id' => $question->id]);
        $response->assertJsonPath('post_type_id', PostType::Question->value);
    }

    #[Test]
    public function it_renders_the_edit_form(): void
    {
        /** @Arrange */
        $question = Post::factory()->create(['post_type_id' => PostType::Question->value]);

        /** @Act */
        $response = $this->get(route('question.edit', $question));

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl('edit', ['record' => $question->getKey()]));
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
        $response->assertRedirect(QuestionResource::getUrl('view', ['record' => $question->getKey()]));
        $this->assertDatabaseHas('posts', [
            'id' => $question->id,
            'title' => 'Updated title',
            'body' => 'Updated body',
            'is_blog' => true,
        ]);
    }

    #[Test]
    public function it_requires_a_title_when_updating(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $question = Post::factory()->create(['user_id' => $user->id]);
        $tags = Tag::factory(2)->create();

        /** @Act */
        $response = $this->from(QuestionResource::getUrl('edit', ['record' => $question->getKey()]))
            ->actingAs($user)
            ->patch(route('question.update', $question), [
                'title' => '',
                'body' => 'Updated body',
                'tags' => $tags->pluck('id')->all(),
            ]);

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl('edit', ['record' => $question->getKey()]));
        $response->assertSessionHasErrors(['title']);
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
        $response->assertRedirect(QuestionResource::getUrl());
        $this->assertDatabaseMissing('posts', ['id' => $question->id]);
    }

    #[Test]
    public function it_requires_at_least_one_tag_when_creating(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->from(QuestionResource::getUrl('create'))->actingAs($user)->post(route('question.store'), [
            'title' => 'Validation title',
            'body' => 'Validation body',
            'tags' => [],
        ]);

        /** @Assert */
        $response->assertRedirect(QuestionResource::getUrl('create'));
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
