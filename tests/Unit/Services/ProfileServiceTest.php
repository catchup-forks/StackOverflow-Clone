<?php

namespace Tests\Unit\Services;

use App\Services\ProfileService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProfileService::class)]
class ProfileServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_updates_a_profile_and_user_fields(): void
    {
        /** @Arrange */
        $service = new ProfileService();
        $user = User::factory()->create();

        /** @Act */
        $profile = $service->update($user, [
            'bio' => 'Developer',
            'location' => 'Remote',
            'website_url' => 'https://example.com',
        ]);

        /** @Assert */
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'bio' => 'Developer',
        ]);
        $this->assertEquals('Remote', $user->fresh()->location);
    }

    #[Test]
    public function it_requires_profile_data(): void
    {
        /** @Arrange */
        $service = new ProfileService();
        $user = User::factory()->create();

        /** @Assert */
        $this->expectException(InvalidArgumentException::class);

        /** @Act */
        $service->update($user, []);
    }
}
