<?php

namespace Tests\Feature\Filament\Admin;

use App\Enums\PostType;
use App\Filament\Admin\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

#[CoversClass(ListPosts::class)]
class PostResourceCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    }

    protected function actingAsAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Livewire::actingAs($admin);

        return $admin;
    }

    #[Test]
    public function admin_can_create_posts_via_modal(): void
    {
        $this->actingAsAdmin();

        $author = User::factory()->create(['display_name' => 'Filament Author']);

        Livewire::test(ListPosts::class)
            ->callAction('create', data: [
                'title' => 'Admin Created Question',
                'post_type_id' => PostType::Question->value,
                'user_id' => $author->id,
                'is_blog' => true,
                'tags' => ['Filament', 'Laravel'],
                'body' => '## New admin-managed question',
                'owner_display_name' => $author->display_name,
                'score' => 5,
                'view_count' => 25,
                'answer_count' => 0,
                'comment_count' => 0,
                'favorite_count' => 0,
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('posts', [
            'title' => 'Admin Created Question',
            'tags' => 'filament,laravel',
        ]);

        $post = Post::query()->where('title', 'Admin Created Question')->firstOrFail();

        $this->assertSame(['filament', 'laravel'], $post->tags()->orderBy('name')->pluck('name')->values()->all());
    }

    #[Test]
    public function admin_can_update_posts_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create([
            'title' => 'Original Question Title',
            'tags' => 'testing,legacy',
        ]);

        $existingTag = Tag::factory()->create(['name' => 'filament', 'count' => 100]);

        $post->tags()->attach($existingTag);

        Livewire::test(ListPosts::class)
            ->callTableAction('edit', $post->getKey(), data: [
                'title' => 'Updated Admin Question',
                'post_type_id' => $post->post_type_id,
                'user_id' => $post->user_id,
                'is_blog' => true,
                'tags' => ['Filament', 'Refactor'],
                'body' => '### Updated body copy',
                'owner_display_name' => $post->owner_display_name,
                'score' => 42,
                'view_count' => 420,
                'answer_count' => 3,
                'comment_count' => 1,
                'favorite_count' => 2,
            ])
            ->assertHasNoActionErrors();

        $post->refresh();

        $this->assertSame('Updated Admin Question', $post->title);
        $this->assertSame('filament,refactor', $post->tags);
        $this->assertSame(['filament', 'refactor'], $post->tags()->orderBy('name')->pluck('name')->values()->all());
    }

    #[Test]
    public function admin_can_delete_posts_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create([
            'title' => 'Disposable Question',
        ]);

        Livewire::test(ListPosts::class)
            ->callTableAction('delete', $post->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
