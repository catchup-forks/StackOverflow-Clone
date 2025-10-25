<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

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
}
