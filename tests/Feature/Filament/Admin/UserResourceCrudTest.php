<?php

namespace Tests\Feature\Filament\Admin;

use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListUsers::class)]
class UserResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_users_via_modal(): void
    {
        $this->actingAsAdmin();

        Livewire::test(ListUsers::class)
            ->callAction('create', data: [
                'display_name' => 'Nordic Hero',
                'email' => 'hero@example.com',
                'website_url' => 'https://example.com',
                'location' => 'Tromsø',
                'about_me' => '<p>Loves Filament</p>',
                'reputation' => 1000,
                'views' => 500,
                'up_votes' => 250,
                'down_votes' => 10,
                'age' => 33,
                'creation_date' => Carbon::parse('2023-11-01 09:00')->format('Y-m-d H:i'),
                'last_access_date' => Carbon::parse('2024-02-01 12:00')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('users', [
            'display_name' => 'Nordic Hero',
            'email' => 'hero@example.com',
            'location' => 'Tromsø',
        ]);
    }

    #[Test]
    public function admin_can_update_users_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $user = User::factory()->create([
            'display_name' => 'Original Name',
            'reputation' => 100,
        ]);

        Livewire::test(ListUsers::class)
            ->callTableAction('edit', $user->getKey(), data: [
                'display_name' => 'Updated Name',
                'email' => 'updated@example.com',
                'website_url' => 'https://updated.dev',
                'location' => 'Oslo',
                'about_me' => '<p>Updated bio</p>',
                'reputation' => 9001,
                'views' => 321,
                'up_votes' => 123,
                'down_votes' => 4,
                'age' => 40,
                'creation_date' => Carbon::parse('2023-01-05 08:00')->format('Y-m-d H:i'),
                'last_access_date' => Carbon::parse('2024-03-01 08:00')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $user->refresh();

        $this->assertSame('Updated Name', $user->display_name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertSame(9001, $user->reputation);
        $this->assertSame('Oslo', $user->location);
    }

    #[Test]
    public function admin_can_delete_users_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $user = User::factory()->create();

        Livewire::test(ListUsers::class)
            ->callTableAction('delete', $user->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function user_creation_requires_display_name(): void
    {
        $this->actingAsAdmin();

        Livewire::test(ListUsers::class)
            ->callAction('create', data: [
                'display_name' => '',
            ])
            ->assertHasActionErrors(['display_name']);
    }
}
