<?php

namespace Tests\Feature;

use App\Enums\PostType;
use App\Enums\VoteType;
use App\Models\Comment;
use App\Models\CommentUpvote;
use App\Models\Post;
use App\Models\SuggestedEdit;
use App\Models\User;
use App\Models\Vote;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserAdminWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $this->user = User::factory()->create([
            'display_name' => 'Curious User',
        ]);

        $this->admin = User::factory()->create([
            'display_name' => 'Admin User',
        ]);

        $this->admin->assignRole('admin');
    }

    #[Test]
    public function user_can_paginate_question_list(): void
    {
        Post::factory()->count(100)->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $response = $this->actingAs($this->user)->getJson(route('question.index'));

        $response->assertOk();
        $response->assertJsonPath('meta.total', 100);
        $response->assertJsonPath('meta.per_page', 15);
        $response->assertJsonCount(15, 'data');
    }

    #[Test]
    public function user_can_comment_on_multiple_questions(): void
    {
        $questions = Post::factory()->count(5)->create([
            'post_type_id' => PostType::Question->value,
        ]);

        foreach ($questions as $offset => $question) {
            $commentResponse = $this->actingAs($this->user)->postJson(route('comments.store'), [
                'post_id' => $question->id,
                'body' => 'Helpful insight #'.($offset + 1),
            ]);

            $commentResponse->assertCreated();
            $commentResponse->assertJsonFragment(['message' => trans('messages.comment.created')]);
            $this->assertSame(1, $question->fresh()->comment_count);
        }
    }

    #[Test]
    public function user_can_flag_comment_for_admin_review(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->postJson(route('comments.flag', $comment));

        $response->assertOk();
        $response->assertJsonFragment(['message' => trans('messages.comment.flagged')]);
        $this->assertTrue($comment->fresh()->requires_admin_review);
    }

    #[Test]
    public function user_can_request_admin_edits_for_questions(): void
    {
        $questions = Post::factory()->count(3)->create([
            'post_type_id' => PostType::Question->value,
        ]);

        foreach ($questions as $question) {
            SuggestedEdit::factory()->create([
                'post_id' => $question->id,
                'owner_user_id' => $this->user->id,
                'comment' => 'Needs admin polish',
            ]);
        }

        $this->assertSame(3, SuggestedEdit::query()
            ->where('owner_user_id', $this->user->id)
            ->count());
    }

    #[Test]
    public function user_can_update_owned_questions(): void
    {
        $ownedQuestions = Post::factory()->count(2)->create([
            'post_type_id' => PostType::Question->value,
            'user_id' => $this->user->id,
            'owner_display_name' => $this->user->display_name,
        ]);

        foreach ($ownedQuestions as $index => $question) {
            $response = $this->actingAs($this->user)->patchJson(route('question.update', $question), [
                'title' => 'Updated question copy '.($index + 1),
                'body' => '### Revised body text version '.($index + 1),
                'tags' => ['Laravel', 'Testing', 'Filament'],
                'is_blog' => $index % 2 === 0,
            ]);

            $response->assertOk();
            $response->assertJsonFragment(['message' => trans('messages.question.updated')]);
            $this->assertSame('Updated question copy '.($index + 1), $question->fresh()->title);
        }
    }

    #[Test]
    public function user_can_submit_answer_for_question(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $response = $this->actingAs($this->user)->postJson(route('answer.store'), [
            'question_id' => $question->id,
            'body' => 'This answer resolves the issue with an example.',
        ]);

        $response->assertCreated();
        $this->assertSame(1, $question->fresh()->answer_count);
    }

    #[Test]
    public function user_can_view_question_with_accepted_answer(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
            'user_id' => $this->user->id,
        ]);

        $answerAuthor = User::factory()->create([
            'display_name' => 'Helpful Expert',
        ]);

        $acceptedAnswer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $answerAuthor->id,
            'owner_display_name' => $answerAuthor->display_name,
            'body' => 'Try clearing your application cache before retrying.',
        ]);

        $question->update([
            'accepted_answer_id' => $acceptedAnswer->id,
            'answer_count' => 1,
        ]);

        $response = $this->actingAs($this->user)->getJson(route('question.show', $question));

        $response->assertOk();
        $response->assertJsonPath('post.id', $question->id);
        $response->assertJsonPath('post.accepted_answer_id', $acceptedAnswer->id);
        $response->assertJsonFragment(['body' => $acceptedAnswer->body]);
    }

    #[Test]
    public function user_can_view_other_profile_and_update_own_profile(): void
    {
        $answerAuthor = User::factory()->create([
            'display_name' => 'Helpful Expert',
        ]);

        $profileResponse = $this->actingAs($this->user)->getJson(route('users.show', $answerAuthor));
        $profileResponse->assertOk();
        $profileResponse->assertJsonPath('id', $answerAuthor->id);

        $updateResponse = $this->actingAs($this->user)->postJson(route('users.profile', $this->user), [
            'bio' => 'Favorited profile: '.$answerAuthor->display_name,
            'location' => 'Internet',
        ]);

        $updateResponse->assertOk();
        $updateResponse->assertJsonFragment(['message' => trans('messages.user.profile_updated')]);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $this->user->id,
            'bio' => 'Favorited profile: '.$answerAuthor->display_name,
        ]);
    }

    #[Test]
    public function admin_can_resolve_flagged_comment(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => true,
        ]);

        $response = $this->actingAs($this->admin)->patchJson(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Reviewed and resolved by admin.',
            'requires_admin_review' => false,
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['message' => trans('messages.comment.admin_updated')]);
        $this->assertFalse($comment->fresh()->requires_admin_review);
    }

    #[Test]
    public function admin_can_update_question_and_answer(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
            'user_id' => $this->user->id,
            'owner_display_name' => $this->user->display_name,
        ]);

        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $this->user->id,
        ]);

        $questionResponse = $this->actingAs($this->admin)->patch(route('admin.posts.update', $question), [
            'title' => 'Admin polished title',
            'body' => 'Admin reviewed content for clarity.',
            'tags' => ['laravel', 'admin-review'],
            'is_blog' => false,
        ]);

        $questionResponse->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('posts', [
            'id' => $question->id,
            'title' => 'Admin polished title',
        ]);

        $answerResponse = $this->actingAs($this->admin)->patch(route('admin.posts.update', $answer), [
            'title' => 'Admin updated answer summary',
            'body' => 'Admin ensured the solution follows guidelines.',
            'is_blog' => false,
        ]);

        $answerResponse->assertRedirect(route('question.show', ['question' => $answer->parent_id]));
        $this->assertDatabaseHas('posts', [
            'id' => $answer->id,
            'body' => 'Admin ensured the solution follows guidelines.',
        ]);
    }

    #[Test]
    public function guest_cannot_create_comments(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $response = $this->postJson(route('comments.store'), [
            'post_id' => $question->id,
            'body' => 'Guest attempt',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function guest_cannot_flag_comments(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->postJson(route('comments.flag', $comment));

        $response->assertForbidden();
    }

    #[Test]
    public function non_owner_cannot_update_question(): void
    {
        $questionOwner = User::factory()->create();

        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
            'user_id' => $questionOwner->id,
        ]);

        $response = $this->actingAs($this->user)->patchJson(route('question.update', $question), [
            'title' => 'Unauthorized edit',
            'body' => 'Attempted body edit',
            'tags' => ['laravel'],
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function non_owner_cannot_update_answer(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $answerOwner = User::factory()->create();

        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $answerOwner->id,
        ]);

        $response = $this->actingAs($this->user)->patchJson(route('answer.update', $answer), [
            'body' => 'Attempted answer edit',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function non_admin_cannot_perform_admin_comment_updates(): void
    {
        $comment = Comment::factory()->create([
            'requires_admin_review' => true,
        ]);

        $response = $this->actingAs($this->user)->patchJson(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Trying to resolve',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function admin_can_clear_requires_admin_review_flag(): void
    {
        $comment = Comment::factory()->create([
            'requires_admin_review' => true,
        ]);

        $response = $this->actingAs($this->admin)->patchJson(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Admin resolved comment edge case.',
            'requires_admin_review' => false,
        ]);

        $response->assertOk();
        $this->assertFalse($comment->fresh()->requires_admin_review);
    }

    #[Test]
    public function duplicate_comment_upvotes_do_not_create_additional_records(): void
    {
        $comment = Comment::factory()->create([
            'score' => 10,
        ]);

        $upvoteUser = User::factory()->create();

        $this->actingAs($upvoteUser);

        CommentUpvote::query()->firstOrCreate([
            'comment_id' => $comment->id,
            'user_id' => $upvoteUser->id,
        ]);

        app(CommentService::class)->upvote($comment->fresh(), $upvoteUser);
        app(CommentService::class)->upvote($comment->fresh(), $upvoteUser);

        $this->assertEquals(12, $comment->fresh()->score);
        $this->assertSame(1, CommentUpvote::query()
            ->where('comment_id', $comment->id)
            ->where('user_id', $upvoteUser->id)
            ->count());
    }

    #[Test]
    public function user_can_record_accepted_answer_vote(): void
    {
        $question = Post::factory()->create([
            'post_type_id' => PostType::Question->value,
            'user_id' => $this->user->id,
        ]);

        $answerAuthor = User::factory()->create();

        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $answerAuthor->id,
        ]);

        $vote = Vote::factory()->create([
            'post_id' => $answer->id,
            'user_id' => $this->user->id,
            'vote_type_id' => VoteType::AcceptedByOriginator->value,
        ]);

        $this->assertDatabaseHas('votes', [
            'id' => $vote->id,
            'vote_type_id' => VoteType::AcceptedByOriginator->value,
        ]);
    }
}
