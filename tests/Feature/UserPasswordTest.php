<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserPasswordTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_updates_the_user_password(): void
    {
        // Arrange
        $user = User::factory()->create([
            'password' => bcrypt('old-password'),
        ]);

        // Act
        $response = $this->actingAs($user)->post(route('users.password', $user), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        // Assert
        $response->assertRedirect(route('users.show', $user));
        $this->assertTrue(password_verify('new-password', $user->fresh()->password));
    }
}
