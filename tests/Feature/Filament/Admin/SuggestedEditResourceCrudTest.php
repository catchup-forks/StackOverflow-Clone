<?php

namespace Tests\Feature\Filament\Admin;

use App\Filament\Admin\Resources\SuggestedEditResource\Pages\ListSuggestedEdits;
use App\Models\Post;
use App\Models\SuggestedEdit;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListSuggestedEdits::class)]
class SuggestedEditResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_suggested_edits_via_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create(['title' => 'Legacy question']);
        $suggestor = User::factory()->create(['display_name' => 'Power Editor']);

        Livewire::test(ListSuggestedEdits::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'owner_user_id' => $suggestor->id,
                'title' => 'Improve legacy formatting',
                'tags' => ['Laravel', 'Filament', 'filament'],
                'body' => '<p>Refined body</p>',
                'comment' => '<p>Applied Nord theme</p>',
                'creation_date' => Carbon::parse('2024-01-20 11:10')->format('Y-m-d H:i'),
                'approval_date' => Carbon::parse('2024-01-22 09:00')->format('Y-m-d H:i'),
                'rejection_date' => Carbon::parse('2024-01-22 09:00')->format('Y-m-d H:i'),
                'revision_GUID' => 777001,
            ])
            ->assertHasNoActionErrors();

        $edit = SuggestedEdit::query()->where('title', 'Improve legacy formatting')->firstOrFail();

        $this->assertSame($post->id, $edit->post_id);
        $this->assertSame($suggestor->id, $edit->owner_user_id);
        $this->assertSame(777001, $edit->revision_GUID);
        $this->assertTrue(str_contains($edit->tags, 'filament'));
        $this->assertTrue(str_contains($edit->tags, 'laravel'));
    }

    #[Test]
    public function admin_can_update_suggested_edits_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $edit = SuggestedEdit::factory()->create([
            'title' => 'Original title',
            'tags' => 'laravel,php',
        ]);

        Livewire::test(ListSuggestedEdits::class)
            ->callTableAction('edit', $edit->getKey(), data: [
                'post_id' => $edit->post_id,
                'owner_user_id' => $edit->owner_user_id,
                'title' => 'Updated suggestion title',
                'tags' => ['Testing', 'Filament'],
                'body' => '<p>Updated body content</p>',
                'comment' => '<p>Updated comment</p>',
                'creation_date' => Carbon::parse('2024-02-05 10:15')->format('Y-m-d H:i'),
                'approval_date' => Carbon::parse('2024-02-06 12:00')->format('Y-m-d H:i'),
                'rejection_date' => Carbon::parse('2024-02-06 12:00')->format('Y-m-d H:i'),
                'revision_GUID' => 888222,
            ])
            ->assertHasNoActionErrors();

        $edit->refresh();

        $this->assertSame('Updated suggestion title', $edit->title);
        $this->assertSame(888222, $edit->revision_GUID);
        $this->assertTrue(str_contains($edit->tags, 'filament'));
    }

    #[Test]
    public function admin_can_delete_suggested_edits_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $edit = SuggestedEdit::factory()->create();

        Livewire::test(ListSuggestedEdits::class)
            ->callTableAction('delete', $edit->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('suggested_edits', ['id' => $edit->id]);
    }

    #[Test]
    public function suggested_edit_creation_requires_creation_date(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $suggestor = User::factory()->create();

        Livewire::test(ListSuggestedEdits::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'owner_user_id' => $suggestor->id,
                'title' => 'Missing dates',
                'tags' => ['Laravel'],
                'body' => '<p>Body</p>',
                'comment' => '<p>Comment</p>',
                'creation_date' => null,
                'approval_date' => Carbon::now()->format('Y-m-d H:i'),
                'rejection_date' => Carbon::now()->format('Y-m-d H:i'),
                'revision_GUID' => 1000,
            ])
            ->assertHasActionErrors(['creation_date']);
    }
}
