<?php

namespace Tests\Feature\Filament\Admin;

use App\Enums\PostHistoryType;
use App\Filament\Admin\Resources\PostHistoryResource\Pages\ListPostHistories;
use App\Models\Post;
use App\Models\PostHistory;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListPostHistories::class)]
class PostHistoryResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_post_histories_via_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $editor = User::factory()->create();

        Livewire::test(ListPostHistories::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $editor->id,
                'post_history_type_id' => PostHistoryType::EditBody->value,
                'revision_GUID' => 123456,
                'on_date' => Carbon::parse('2024-01-10 12:15')->format('Y-m-d H:i'),
                'user_display_name' => 'Editorial Bot',
                'comment' => '<p>Adjusted formatting</p>',
                'body' => '<p>Revised body snapshot</p>',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('post_histories', [
            'post_id' => $post->id,
            'user_id' => $editor->id,
            'post_history_type_id' => PostHistoryType::EditBody->value,
            'revision_GUID' => 123456,
        ]);
    }

    #[Test]
    public function admin_can_update_post_histories_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $history = PostHistory::factory()->create([
            'post_history_type_id' => PostHistoryType::InitialBody->value,
            'comment' => '<p>Original comment</p>',
        ]);

        Livewire::test(ListPostHistories::class)
            ->callTableAction('edit', $history->getKey(), data: [
                'post_id' => $history->post_id,
                'user_id' => $history->user_id,
                'post_history_type_id' => PostHistoryType::EditTags->value,
                'revision_GUID' => 987654,
                'on_date' => Carbon::parse('2024-04-05 16:20')->format('Y-m-d H:i'),
                'user_display_name' => $history->user_display_name,
                'comment' => '<p>Updated tags</p>',
                'body' => '<p>Body snapshot</p>',
            ])
            ->assertHasNoActionErrors();

        $history->refresh();

        $this->assertSame(PostHistoryType::EditTags->value, $history->post_history_type_id);
        $this->assertSame(987654, $history->revision_GUID);
        $this->assertSame('<p>Updated tags</p>', $history->comment);
    }

    #[Test]
    public function admin_can_delete_post_histories_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $history = PostHistory::factory()->create();

        Livewire::test(ListPostHistories::class)
            ->callTableAction('delete', $history->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('post_histories', ['id' => $history->id]);
    }

    #[Test]
    public function post_history_creation_requires_revision_guid(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $editor = User::factory()->create();

        Livewire::test(ListPostHistories::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $editor->id,
                'post_history_type_id' => PostHistoryType::EditBody->value,
                'revision_GUID' => null,
                'on_date' => Carbon::now()->format('Y-m-d H:i'),
            ])
            ->assertHasActionErrors(['revision_GUID']);
    }
}
