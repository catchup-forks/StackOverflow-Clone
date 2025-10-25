<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_admins_to_update_a_post(): void
    {
        // Arrange
        \Spatie\Permission\Models\Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $question = Post::factory()->create(['post_type_id' => 1]);
        $tags = Tag::factory(2)->create();

        // Act
        $response = $this->actingAs($admin)->patch(route('admin.posts.update', $question), [
            'title' => 'Updated title',
            'body' => 'Updated body',
            'tags' => $tags->pluck('id')->all(),
            'is_blog' => true,
        ]);

        // Assert
        $response->assertRedirect(route('question.show', ['question' => $question->id]));
        $this->assertDatabaseHas('posts', [
            'id' => $question->id,
            'title' => 'Updated title',
            'is_blog' => true,
        ]);
    }
}
