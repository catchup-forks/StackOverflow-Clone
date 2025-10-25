<?php

namespace Tests\Feature\Filament\Admin;

use App\Filament\Admin\Resources\BadgeResource\Pages\ListBadges;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListBadges::class)]
class BadgeResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_badges_via_modal(): void
    {
        $this->actingAsAdmin();

        $recipient = User::factory()->create(['display_name' => 'Helpful Human']);

        Livewire::test(ListBadges::class)
            ->callAction('create', data: [
                'name' => 'Legendary Helper',
                'user_id' => $recipient->id,
                'date' => Carbon::parse('2024-01-01 10:00')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('badges', [
            'name' => 'Legendary Helper',
            'user_id' => $recipient->id,
        ]);
    }

    #[Test]
    public function admin_can_update_badges_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $badge = Badge::factory()->create();
        $newRecipient = User::factory()->create(['display_name' => 'Another User']);

        Livewire::test(ListBadges::class)
            ->callTableAction('edit', $badge->getKey(), data: [
                'name' => 'Refined Badge',
                'user_id' => $newRecipient->id,
                'date' => Carbon::parse('2024-02-15 09:30')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $badge->refresh();

        $this->assertSame('Refined Badge', $badge->name);
        $this->assertSame($newRecipient->id, $badge->user_id);
        $this->assertTrue(Carbon::parse($badge->date)->equalTo(Carbon::parse('2024-02-15 09:30')));
    }

    #[Test]
    public function admin_can_delete_badges_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $badge = Badge::factory()->create();

        Livewire::test(ListBadges::class)
            ->callTableAction('delete', $badge->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('badges', ['id' => $badge->id]);
    }

    #[Test]
    public function badge_creation_requires_a_name(): void
    {
        $this->actingAsAdmin();

        $recipient = User::factory()->create();

        Livewire::test(ListBadges::class)
            ->callAction('create', data: [
                'name' => '',
                'user_id' => $recipient->id,
                'date' => Carbon::now()->format('Y-m-d H:i'),
            ])
            ->assertHasActionErrors(['name']);
    }
}
