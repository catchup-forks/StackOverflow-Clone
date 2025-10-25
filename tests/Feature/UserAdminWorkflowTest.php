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
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserAdminWorkflowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_covers_end_to_end_user_and_admin_flow(): void
    {
        /** @Arrange */
        \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create([
            'display_name' => 'Curious User',
        ]);

        $admin = User::factory()->create([
            'display_name' => 'Admin User',
        ]);
        $admin->assignRole('admin');

        $questions = Post::factory()->count(100)->create([
            'post_type_id' => PostType::Question->value,
        ]);

        $questions->take(2)->each(function (Post $question) use ($user): void {
            $question->update([
                'user_id' => $user->id,
                'owner_display_name' => $user->display_name,
                'title' => 'Maintaining legacy Laravel '.$question->id,
            ]);
        });

        /** @Act: user browses paginated questions */
        $indexResponse = $this->actingAs($user)->getJson(route('question.index'));

        /** @Assert */
        $indexResponse->assertOk();
        $indexResponse->assertJsonPath('meta.total', 100);
        $indexResponse->assertJsonPath('meta.per_page', 15);
        $indexResponse->assertJsonCount(15, 'data');

        /** @Act: user comments on five different questions */
        $commentedQuestions = $questions->take(5);
        $createdComments = collect();

        foreach ($commentedQuestions as $offset => $question) {
            $commentResponse = $this->actingAs($user)->postJson(route('comments.store'), [
                'post_id' => $question->id,
                'body' => "Helpful insight #".($offset + 1),
            ]);

            $commentResponse->assertCreated();
            $commentResponse->assertJsonFragment(['message' => trans('messages.comment.created')]);

            $commentId = $commentResponse->json('comment.id');
            $this->assertNotNull($commentId);

            $createdComments->push(Comment::query()->findOrFail($commentId));

            $this->assertSame(1, $question->fresh()->comment_count);
        }

        /** @Act: user flags three comments for admin review */
        foreach ($createdComments->take(3) as $comment) {
            $flagResponse = $this->actingAs($user)->postJson(route('comments.flag', $comment));
            $flagResponse->assertOk();
            $flagResponse->assertJsonFragment(['message' => trans('messages.comment.flagged')]);
            $this->assertTrue($comment->fresh()->requires_admin_review);
        }

        /** @Act: user requests admin edits on three questions via suggested edits */
        foreach ($commentedQuestions->take(3) as $question) {
            SuggestedEdit::factory()->create([
                'post_id' => $question->id,
                'owner_user_id' => $user->id,
                'comment' => 'Needs admin polish',
            ]);
        }

        /** @Act: user updates two of their own questions */
        $ownedQuestions = $questions->where('user_id', $user->id)->take(2);
        $ownedQuestions->each(function (Post $question, int $index) use ($user): void {
            $updateResponse = $this->actingAs($user)->patchJson(route('question.update', $question), [
                'title' => "Updated question copy ".($index + 1),
                'body' => "### Revised body text version ".($index + 1),
                'tags' => ['Laravel', 'Testing', 'Filament'],
                'is_blog' => $index % 2 === 0,
            ]);

            $updateResponse->assertOk();
            $updateResponse->assertJsonFragment(['message' => trans('messages.question.updated')]);

            $question->refresh();
            $this->assertSame("Updated question copy ".($index + 1), $question->title);
            $this->assertEquals($index % 2 === 0, $question->is_blog);
        });

        /** @Act: user answers one of the public questions */
        $targetQuestion = $questions->skip(5)->first();

        $answerResponse = $this->actingAs($user)->postJson(route('answer.store'), [
            'question_id' => $targetQuestion->id,
            'body' => 'This answer resolves the issue with an example.',
        ]);

        $answerResponse->assertCreated();
        $targetQuestion->refresh();
        $this->assertSame(1, $targetQuestion->answer_count);

        $userQuestion = $ownedQuestions->first();
        $answerAuthor = User::factory()->create(['display_name' => 'Helpful Expert']);
        $acceptedAnswer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $userQuestion->id,
            'user_id' => $answerAuthor->id,
            'owner_display_name' => $answerAuthor->display_name,
            'body' => 'Try clearing your application cache before retrying.',
        ]);

        $userQuestion->update([
            'accepted_answer_id' => $acceptedAnswer->id,
            'answer_count' => 1,
        ]);

        /** @Act: user reviews their historical question with answers */
        $showResponse = $this->actingAs($user)->getJson(route('question.show', $userQuestion));

        $showResponse->assertOk();
        $showResponse->assertJsonPath('post.id', $userQuestion->id);
        $showResponse->assertJsonPath('post.accepted_answer_id', $acceptedAnswer->id);
        $showResponse->assertJsonFragment(['body' => $acceptedAnswer->body]);

        /** @Act: user records an accepted-answer vote */
        $vote = Vote::factory()->create([
            'post_id' => $acceptedAnswer->id,
            'user_id' => $user->id,
            'vote_type_id' => VoteType::AcceptedByOriginator->value,
        ]);
        $this->assertDatabaseHas('votes', ['id' => $vote->id, 'vote_type_id' => VoteType::AcceptedByOriginator->value]);

        /** @Act: user views the answerer profile and updates their own profile */
        $profileResponse = $this->actingAs($user)->getJson(route('users.show', $answerAuthor));
        $profileResponse->assertOk();
        $profileResponse->assertJsonPath('id', $answerAuthor->id);

        $profileUpdate = $this->actingAs($user)->postJson(route('users.profile', $user), [
            'bio' => 'Favorited profile: '.$answerAuthor->display_name,
            'location' => 'Internet',
        ]);

        $profileUpdate->assertOk();
        $profileUpdate->assertJsonFragment(['message' => trans('messages.user.profile_updated')]);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'bio' => 'Favorited profile: '.$answerAuthor->display_name,
        ]);

        auth()->logout();

        /** @Act: admin reviews flagged content */
        $flaggedComment = $createdComments->firstWhere('requires_admin_review');
        $adminCommentResponse = $this->actingAs($admin)->patchJson(route('comments.adminUpdate', $flaggedComment), [
            'post_id' => $flaggedComment->post_id,
            'body' => 'Reviewed and resolved by admin.',
            'requires_admin_review' => false,
        ]);

        $adminCommentResponse->assertOk();
        $adminCommentResponse->assertJsonFragment(['message' => trans('messages.comment.admin_updated')]);
        $this->assertFalse($flaggedComment->fresh()->requires_admin_review);

        /** @Act: admin edits a question and an answer */
        $adminQuestionResponse = $this->actingAs($admin)->patch(route('admin.posts.update', $userQuestion), [
            'title' => 'Admin polished title',
            'body' => 'Admin reviewed content for clarity.',
            'tags' => ['laravel', 'admin-review'],
            'is_blog' => false,
        ]);

        $adminQuestionResponse->assertRedirect(route('question.show', ['question' => $userQuestion->id]));
        $this->assertDatabaseHas('posts', [
            'id' => $userQuestion->id,
            'title' => 'Admin polished title',
        ]);

        $adminAnswerResponse = $this->actingAs($admin)->patch(route('admin.posts.update', $acceptedAnswer), [
            'title' => 'Admin updated answer summary',
            'body' => 'Admin ensured the solution follows guidelines.',
            'is_blog' => false,
        ]);

        $adminAnswerResponse->assertRedirect(route('question.show', ['question' => $acceptedAnswer->parent_id]));
        $this->assertDatabaseHas('posts', [
            'id' => $acceptedAnswer->id,
            'body' => 'Admin ensured the solution follows guidelines.',
        ]);
    }

    #[Test]
    public function it_handles_edge_cases_for_the_user_and_admin_workflow(): void
    {
        /** @Arrange */
        \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $question = Post::factory()->create([
            'user_id' => $user->id,
            'owner_display_name' => $user->display_name,
        ]);

        $answer = Post::factory()->create([
            'post_type_id' => PostType::Answer->value,
            'parent_id' => $question->id,
            'user_id' => $user->id,
        ]);

        $comment = Comment::factory()->create([
            'post_id' => $question->id,
            'requires_admin_review' => true,
        ]);

        /** @Assert: guests cannot create comments */
        $guestComment = $this->postJson(route('comments.store'), [
            'post_id' => $question->id,
            'body' => 'Guest attempt',
        ]);
        $guestComment->assertForbidden();

        /** @Assert: guests cannot flag comments */
        $guestFlag = $this->postJson(route('comments.flag', $comment));
        $guestFlag->assertForbidden();

        /** @Assert: non-owners cannot update questions */
        $unauthorizedUpdate = $this->actingAs($otherUser)->patchJson(route('question.update', $question), [
            'title' => 'Unauthorized edit',
            'body' => 'Attempted body edit',
            'tags' => ['laravel'],
        ]);
        $unauthorizedUpdate->assertForbidden();

        /** @Assert: non-owners cannot update answers */
        $unauthorizedAnswerUpdate = $this->actingAs($otherUser)->patchJson(route('answer.update', $answer), [
            'body' => 'Attempted answer edit',
        ]);
        $unauthorizedAnswerUpdate->assertForbidden();

        /** @Assert: non-admins cannot resolve admin comment updates */
        $nonAdminAdminUpdate = $this->actingAs($otherUser)->patchJson(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Trying to resolve',
        ]);
        $nonAdminAdminUpdate->assertForbidden();

        /** @Assert: admin resolves comment and ensures flag cleared */
        $adminUpdate = $this->actingAs($admin)->patchJson(route('comments.adminUpdate', $comment), [
            'post_id' => $comment->post_id,
            'body' => 'Admin resolved comment edge case.',
            'requires_admin_review' => false,
        ]);
        $adminUpdate->assertOk();
        $this->assertFalse($comment->fresh()->requires_admin_review);

        /** @Assert: duplicate comment upvotes reuse the same upvote record */
        $upvoteUser = User::factory()->create();
        $this->actingAs($upvoteUser);
        CommentUpvote::query()->firstOrCreate([
            'comment_id' => $comment->id,
            'user_id' => $upvoteUser->id,
        ]);

        $comment->update(['score' => 10]);

        $this->app->make(\App\Services\CommentService::class)->upvote($comment->fresh(), $upvoteUser);
        $this->app->make(\App\Services\CommentService::class)->upvote($comment->fresh(), $upvoteUser);

        $this->assertEquals(12, $comment->fresh()->score);
        $this->assertSame(1, CommentUpvote::query()
            ->where('comment_id', $comment->id)
            ->where('user_id', $upvoteUser->id)
            ->count());
    }
}
