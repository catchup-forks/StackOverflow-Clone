<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserService::class)]
class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_user_with_roles(): void
    {
        /** @Arrange */
        $service = new UserService();

        /** @Act */
        $user = $service->create([
            'display_name' => 'Taylor Otwell',
            'email' => 'taylor@example.com',
            'password' => 'secret123',
            'roles' => ['admin'],
        ]);

        /** @Assert */
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'taylor@example.com']);
        $this->assertTrue($user->hasRole('admin'));
    }

    #[Test]
    public function it_updates_a_user_and_roles(): void
    {
        /** @Arrange */
        $service = new UserService();
        $user = User::factory()->create();

        /** @Act */
        $updated = $service->update($user, [
            'display_name' => 'Updated',
            'email' => 'updated@example.com',
            'roles' => ['moderator'],
        ]);

        /** @Assert */
        $this->assertEquals('updated@example.com', $updated->email);
        $this->assertTrue($updated->hasRole('moderator'));
    }

    #[Test]
    public function it_updates_and_validates_passwords(): void
    {
        /** @Arrange */
        $service = new UserService();
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        /** @Act */
        $isValid = $service->validateCurrentPassword($user, 'old-password');
        $service->updatePassword($user, 'new-password');

        /** @Assert */
        $this->assertTrue($isValid);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    #[Test]
    public function it_deletes_a_user(): void
    {
        /** @Arrange */
        $service = new UserService();
        $user = User::factory()->create();

        /** @Act */
        $service->delete($user);

        /** @Assert */
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_rejects_invalid_current_passwords(): void
    {
        /** @Arrange */
        $service = new UserService();
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        /** @Act */
        $isValid = $service->validateCurrentPassword($user, 'wrong-password');

        /** @Assert */
        $this->assertFalse($isValid);
    }

    #[Test]
    public function it_throws_when_user_missing_for_recent_posts(): void
    {
        /** @Arrange */
        $service = new UserService();

        /** @Assert */
        $this->expectException(ModelNotFoundException::class);

        /** @Act */
        $service->findWithRecentPosts(999);
    }
}
