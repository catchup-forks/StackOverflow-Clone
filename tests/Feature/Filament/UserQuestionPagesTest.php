<?php

namespace Tests\Feature\Filament;

use App\Enums\PostType;
use App\Filament\User\Resources\QuestionResource\Pages\CreateQuestion;
use App\Filament\User\Resources\QuestionResource\Pages\EditQuestion;
use App\Filament\User\Resources\QuestionResource\Pages\ListQuestions;
use App\Filament\User\Resources\QuestionResource\Pages\ViewQuestion;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ListQuestions::class)]
#[CoversClass(CreateQuestion::class)]
#[CoversClass(EditQuestion::class)]
#[CoversClass(ViewQuestion::class)]
class UserQuestionPagesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function list_page_displays_questions_and_recent_tags(): void
    {
        /** @Arrange */
        $user = User::factory()->create(['display_name' => 'Taylor Otwell']);
        $otherUser = User::factory()->create(['display_name' => 'Jess Archer']);

        Tag::factory()->create(['name' => 'laravel', 'count' => 50]);
        Tag::factory()->create(['name' => 'php', 'count' => 25]);

        $firstQuestion = Post::factory()->create([
            'user_id' => $user->id,
            'owner_display_name' => $user->display_name,
            'title' => 'How do I refactor this app to Filament?',
            'tags' => 'laravel,php',
            'answer_count' => 2,
            'view_count' => 128,
        ]);

        $secondQuestion = Post::factory()->create([
            'user_id' => $otherUser->id,
            'owner_display_name' => $otherUser->display_name,
            'title' => 'How can I test Livewire components?',
            'tags' => 'php,testing',
            'answer_count' => 1,
            'view_count' => 64,
        ]);

        Livewire::actingAs($user);

        /** @Act & Assert */
        Livewire::test(ListQuestions::class)
            ->assertStatus(200)
            ->assertSee('Top Questions')
            ->assertSee('Ask Question')
            ->assertSee(route('question.create'), false)
            ->assertSee($firstQuestion->title)
            ->assertSee((string) $firstQuestion->answer_count)
            ->assertSee((string) $firstQuestion->view_count)
            ->assertSee($secondQuestion->title)
            ->assertSee($user->display_name)
            ->assertSee($otherUser->display_name)
            ->assertSee('Tags')
            ->assertSee('laravel')
            ->assertSee('php');
    }

    #[Test]
    public function create_page_displays_instructional_content(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        Livewire::actingAs($user);

        /** @Act & Assert */
        Livewire::test(CreateQuestion::class)
            ->assertStatus(200)
            ->assertSee('Ask Question')
            ->assertSee('Post a new programming question')
            ->assertSee('Share all relevant details so the community can help quickly.')
            ->assertSee('Writing great questions')
            ->assertSee('Summarise the problem in a single sentence.')
            ->assertSee('Tag the question so experts can find it faster.')
            ->assertSee('Press enter after each tag (markdown supported).');
    }

    #[Test]
    public function user_can_create_questions_via_filament_form(): void
    {
        $user = User::factory()->create(['display_name' => 'Filament Fan']);
        $existingTag = Tag::factory()->create(['name' => 'filament']);

        Livewire::actingAs($user);

        Livewire::test(CreateQuestion::class)
            ->fillForm([
                'title' => 'How do I enable the Nord theme?',
                'body' => '## I want to use **Nord** colors everywhere.',
                'tags' => ['Laravel', ' filament ', (string) $existingTag->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $question = Post::query()->where('title', 'How do I enable the Nord theme?')->firstOrFail();

        $this->assertSame('filament,laravel', $question->tags);
        $this->assertSame($user->id, $question->user_id);
        $this->assertSame(['filament', 'laravel'], $question->tags()->orderBy('name')->pluck('name')->values()->all());
    }

    #[Test]
    public function edit_page_shows_existing_question_details_and_guidance(): void
    {
        /** @Arrange */
        $owner = User::factory()->create(['display_name' => 'Ada Lovelace']);

        $question = Post::factory()->create([
            'user_id' => $owner->id,
            'owner_display_name' => $owner->display_name,
            'title' => 'How do I improve this Filament form?',
            'body' => 'The form needs better validation coverage.',
        ]);

        Livewire::actingAs($owner);

        $expectedHeading = sprintf('Improve “%s”', $question->title);

        /** @Act & Assert */
        Livewire::test(EditQuestion::class, ['record' => $question->getKey()])
            ->assertStatus(200)
            ->assertSee('Edit Question')
            ->assertSee($expectedHeading)
            ->assertSee('Editing reminders')
            ->assertSee('Keep the original intent of the question intact.')
            ->assertSee('Clarify language and improve formatting for readability.')
            ->assertSee('Update tags so experts can continue to find the topic.')
            ->assertSee('Delete question');
    }

    #[Test]
    public function user_can_update_questions_and_sync_tags(): void
    {
        $owner = User::factory()->create(['display_name' => 'Ada Lovelace']);
        $question = Post::factory()->create([
            'user_id' => $owner->id,
            'owner_display_name' => $owner->display_name,
            'title' => 'Original Nord question',
            'body' => 'Initial body',
            'tags' => 'php,legacy',
        ]);

        Tag::factory()->create(['name' => 'testing']);

        Livewire::actingAs($owner);

        Livewire::test(EditQuestion::class, ['record' => $question->getKey()])
            ->fillForm([
                'title' => 'Updated Nord question',
                'body' => '### Updated body copy',
                'tags' => ['Laravel', 'Testing', 'Filament', 'filament'],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $question->refresh();

        $this->assertSame('Updated Nord question', $question->title);
        $this->assertSame('filament,laravel,testing', $question->tags);
        $this->assertSame(['filament', 'laravel', 'testing'], $question->tags()->orderBy('name')->pluck('name')->values()->all());
    }

    #[Test]
    public function view_page_displays_question_answers_and_answer_form(): void
    {
        /** @Arrange */
        $viewer = User::factory()->create();
        $author = User::factory()->create(['display_name' => 'Grace Hopper']);
        $answerAuthor = User::factory()->create(['display_name' => 'Margaret Hamilton']);

        $filamentTag = Tag::factory()->create(['name' => 'filament', 'count' => 100]);
        $testingTag = Tag::factory()->create(['name' => 'testing', 'count' => 80]);

        $question = Post::factory()->create([
            'user_id' => $author->id,
            'owner_display_name' => $author->display_name,
            'title' => 'How do I test Filament question pages?',
            'body' => 'I would like to assert the Blade view content rendered by Livewire.',
            'tags' => 'filament,testing',
            'answer_count' => 2,
        ]);

        $acceptedAnswer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $answerAuthor->id,
            'body' => 'Use Livewire::test and assert the rendered HTML output.',
        ]);

        $otherAnswer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $viewer->id,
            'body' => 'Seed the tags and answers so the view has realistic data.',
        ]);

        $question->update([
            'accepted_answer_id' => $acceptedAnswer->id,
            'answer_count' => 2,
        ]);

        $question->tags()->attach([$filamentTag->id, $testingTag->id]);

        Livewire::actingAs($viewer);

        /** @Act & Assert */
        Livewire::test(ViewQuestion::class, ['record' => $question->getKey()])
            ->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->body)
            ->assertSee('Question info')
            ->assertSee('Know someone who can answer?')
            ->assertSee('2 Answers')
            ->assertSee($acceptedAnswer->body)
            ->assertSee($otherAnswer->body)
            ->assertSee('Post your answer')
            ->assertSee('filament')
            ->assertSee('testing');
    }

    #[Test]
    public function user_can_delete_questions_from_edit_page(): void
    {
        $owner = User::factory()->create();
        $question = Post::factory()->create([
            'user_id' => $owner->id,
            'owner_display_name' => $owner->display_name,
        ]);

        Livewire::actingAs($owner);

        Livewire::test(EditQuestion::class, ['record' => $question->getKey()])
            ->callAction('delete')
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('posts', ['id' => $question->id]);
    }

    #[Test]
    public function creating_a_question_requires_a_title(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user);

        Livewire::test(CreateQuestion::class)
            ->fillForm([
                'title' => '',
                'body' => 'Body without a title',
                'tags' => ['Laravel'],
            ])
            ->call('create')
            ->assertHasFormErrors(['title']);

        $this->assertDatabaseMissing('posts', ['body' => 'Body without a title']);
    }
}
