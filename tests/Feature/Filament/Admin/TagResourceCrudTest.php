<?php

namespace Tests\Feature\Filament\Admin;

use App\Filament\Admin\Resources\TagResource\Pages\ListTags;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListTags::class)]
class TagResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_tags_via_modal(): void
    {
        $this->actingAsAdmin();

        $excerpt = Post::factory()->create(['title' => 'Excerpt Post']);
        $wiki = Post::factory()->create(['title' => 'Wiki Post']);

        Livewire::test(ListTags::class)
            ->callAction('create', data: [
                'name' => 'filament',
                'count' => 42,
                'excerpt_post_id' => $excerpt->id,
                'wiki_post_id' => $wiki->id,
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('tags', [
            'name' => 'filament',
            'count' => 42,
            'excerpt_post_id' => $excerpt->id,
            'wiki_post_id' => $wiki->id,
        ]);
    }

    #[Test]
    public function admin_can_update_tags_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $tag = Tag::factory()->create([
            'name' => 'laravel',
            'count' => 10,
        ]);

        $excerpt = Post::factory()->create(['title' => 'Excerpt']);

        Livewire::test(ListTags::class)
            ->callTableAction('edit', $tag->getKey(), data: [
                'name' => 'laravel-10',
                'count' => 500,
                'excerpt_post_id' => $excerpt->id,
                'wiki_post_id' => null,
            ])
            ->assertHasNoActionErrors();

        $tag->refresh();

        $this->assertSame('laravel-10', $tag->name);
        $this->assertSame(500, $tag->count);
        $this->assertSame($excerpt->id, $tag->excerpt_post_id);
        $this->assertNull($tag->wiki_post_id);
    }

    #[Test]
    public function admin_can_delete_tags_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $tag = Tag::factory()->create();

        Livewire::test(ListTags::class)
            ->callTableAction('delete', $tag->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    #[Test]
    public function tag_creation_requires_a_name(): void
    {
        $this->actingAsAdmin();

        Livewire::test(ListTags::class)
            ->callAction('create', data: [
                'name' => '',
            ])
            ->assertHasActionErrors(['name']);
    }
}
