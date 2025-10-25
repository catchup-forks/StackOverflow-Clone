<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserController::class)]
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lists_users_as_html(): void
    {
        /** @Arrange */
        User::factory()->count(3)->sequence(
            ['display_name' => 'Alice'],
            ['display_name' => 'Bob'],
            ['display_name' => 'Charlie']
        )->create();

        /** @Act */
        $response = $this->get(route('users.index'));

        /** @Assert */
        $response->assertViewIs('public.users.index');
        $response->assertViewHas('users', function ($users) {
            return $users->count() === 3
                && collect($users->items())->pluck('display_name')->contains('Alice');
        });
        $response->assertViewHas('search', fn ($search) => $search === '');
    }

    #[Test]
    public function it_lists_users_as_json(): void
    {
        /** @Arrange */
        $firstUser = User::factory()->create(['display_name' => 'Daisy']);
        $secondUser = User::factory()->create(['display_name' => 'Elliot']);

        /** @Act */
        $response = $this->getJson(route('users.index'));

        /** @Assert */
        $response->assertJsonStructure(['data']);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['display_name' => $firstUser->display_name]);
        $response->assertJsonFragment(['display_name' => $secondUser->display_name]);
    }

    #[Test]
    public function it_renders_the_create_view(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->get(route('users.create'));

        /** @Assert */
        $response->assertViewIs('public.users.create');
    }

    #[Test]
    public function it_creates_a_user(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->post(route('users.store'), [
            'display_name' => 'Taylor',
            'email' => 'taylor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        /** @Assert */
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'taylor@example.com']);
    }

    #[Test]
    public function it_creates_a_user_via_json(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->postJson(route('users.store'), [
            'display_name' => 'Taylor',
            'email' => 'taylor-json@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        /** @Assert */
        $response->assertCreated();
        $response->assertJsonFragment(['email' => 'taylor-json@example.com']);
    }

    #[Test]
    public function it_requires_display_name_when_creating(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->from(route('users.create'))->post(route('users.store'), [
            'display_name' => '',
            'email' => 'invalid@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        /** @Assert */
        $response->assertRedirect(route('users.create'));
        $response->assertSessionHasErrors(['display_name']);
    }

    #[Test]
    public function it_shows_a_user_as_html(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->get(route('users.show', $user));

        /** @Assert */
        $response->assertViewIs('public.user.show');
        $response->assertViewHas('user', fn ($viewUser) => $viewUser->id === $user->id);
        $response->assertViewHas('recentPosts', fn ($recentPosts) => $recentPosts instanceof \Illuminate\Support\Collection);
    }

    #[Test]
    public function it_shows_a_user_as_json(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->getJson(route('users.show', $user));

        /** @Assert */
        $response->assertJson(['id' => $user->id]);
        $response->assertJsonPath('display_name', $user->display_name);
    }

    #[Test]
    public function it_renders_the_edit_view(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->get(route('users.edit', $user));

        /** @Assert */
        $response->assertViewIs('public.user.edit');
        $response->assertViewHas('user', fn ($viewUser) => $viewUser->id === $user->id);
    }

    #[Test]
    public function it_updates_a_user(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->patch(route('users.update', $user), [
            'display_name' => 'Updated',
            'email' => 'updated@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        /** @Assert */
        $response->assertRedirect(route('users.show', $user));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updated@example.com',
        ]);
    }

    #[Test]
    public function it_updates_a_user_via_json(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->patchJson(route('users.update', $user), [
            'display_name' => 'Updated',
            'email' => 'updated-json@example.com',
        ]);

        /** @Assert */
        $response->assertJsonFragment(['email' => 'updated-json@example.com']);
        $response->assertJsonPath('user.id', $user->id);
    }

    #[Test]
    public function it_requires_unique_email_when_updating(): void
    {
        /** @Arrange */
        $user = User::factory()->create(['email' => 'one@example.com']);
        User::factory()->create(['email' => 'taken@example.com']);

        /** @Act */
        $response = $this->from(route('users.edit', $user))
            ->patch(route('users.update', $user), [
                'display_name' => 'Updated',
                'email' => 'taken@example.com',
            ]);

        /** @Assert */
        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function it_updates_a_profile(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->actingAs($user)->post(route('users.profile', $user), [
            'bio' => 'Developer',
            'location' => 'Remote',
            'website_url' => 'https://example.com',
        ]);

        /** @Assert */
        $response->assertRedirect(route('users.show', $user));
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'bio' => 'Developer',
        ]);
    }

    #[Test]
    public function it_updates_a_profile_via_json(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->actingAs($user)->postJson(route('users.profile', $user), [
            'bio' => 'Developer',
        ]);

        /** @Assert */
        $response->assertJsonFragment(['message' => trans('messages.user.profile_updated')]);
        $response->assertJsonPath('profile.bio', 'Developer');
    }

    #[Test]
    public function it_requires_valid_profile_data(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->from(route('users.edit', $user))
            ->actingAs($user)
            ->post(route('users.profile', $user), [
                'website_url' => 'not-a-url',
            ]);

        /** @Assert */
        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHasErrors(['website_url']);
    }

    #[Test]
    public function it_prevents_other_users_from_updating_a_profile(): void
    {
        /** @Arrange */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        /** @Act */
        $response = $this->actingAs($otherUser)->post(route('users.profile', $user), [
            'bio' => 'Hacker',
        ]);

        /** @Assert */
        $response->assertForbidden();
    }

    #[Test]
    public function it_deletes_a_user(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->delete(route('users.destroy', $user));

        /** @Assert */
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_deletes_a_user_via_json(): void
    {
        /** @Arrange */
        $user = User::factory()->create();

        /** @Act */
        $response = $this->deleteJson(route('users.destroy', $user));

        /** @Assert */
        $response->assertJsonFragment(['message' => trans('messages.user.deleted')]);
    }
}
