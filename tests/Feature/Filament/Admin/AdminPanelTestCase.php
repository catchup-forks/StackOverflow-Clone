<?php

namespace Tests\Feature\Filament\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

abstract class AdminPanelTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
    }

    protected function actingAsAdmin(): User
    {
        $admin = User::factory()->create([
            'display_name' => 'Filament Admin',
        ]);

        $admin->assignRole('admin');

        Livewire::actingAs($admin);

        return $admin;
    }
}
