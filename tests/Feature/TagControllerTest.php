<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lists_tags_as_html(): void
    {
        /** @Arrange */
        Tag::factory()->count(3)->create();

        /** @Act */
        $response = $this->get(route('tags.index'));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.tags.index');
    }

    #[Test]
    public function it_lists_tags_as_json(): void
    {
        /** @Arrange */
        Tag::factory()->count(2)->create();

        /** @Act */
        $response = $this->getJson(route('tags.index'));

        /** @Assert */
        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    #[Test]
    public function it_renders_the_create_view(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->get(route('tags.create'));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.tags.create');
    }

    #[Test]
    public function it_creates_a_tag(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->post(route('tags.store'), [
            'name' => 'laravel',
            'count' => 10,
        ]);

        /** @Assert */
        $response->assertRedirect();
        $this->assertDatabaseHas('tags', [
            'name' => 'laravel',
            'count' => 10,
        ]);
    }

    #[Test]
    public function it_shows_a_tag_as_html(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->get(route('tags.show', $tag));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.tags.show');
    }

    #[Test]
    public function it_shows_a_tag_as_json(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->getJson(route('tags.show', $tag));

        /** @Assert */
        $response->assertOk();
        $response->assertJson(['id' => $tag->id]);
    }

    #[Test]
    public function it_renders_the_edit_view(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->get(route('tags.edit', $tag));

        /** @Assert */
        $response->assertOk();
        $response->assertViewIs('public.tags.edit');
    }

    #[Test]
    public function it_updates_a_tag(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->patch(route('tags.update', $tag), [
            'name' => 'php',
            'count' => 20,
        ]);

        /** @Assert */
        $response->assertRedirect(route('tags.show', $tag));
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'php',
            'count' => 20,
        ]);
    }

    #[Test]
    public function it_requires_a_name_when_updating(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->from(route('tags.edit', $tag))
            ->patch(route('tags.update', $tag), [
                'name' => '',
                'count' => 5,
            ]);

        /** @Assert */
        $response->assertRedirect(route('tags.edit', $tag));
        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function it_deletes_a_tag(): void
    {
        /** @Arrange */
        $tag = Tag::factory()->create();

        /** @Act */
        $response = $this->delete(route('tags.destroy', $tag));

        /** @Assert */
        $response->assertRedirect(route('tags.index'));
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    #[Test]
    public function it_requires_valid_data_when_creating(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->from(route('tags.create'))->post(route('tags.store'), [
            'name' => '',
            'count' => -1,
        ]);

        /** @Assert */
        $response->assertRedirect(route('tags.create'));
        $response->assertSessionHasErrors(['name', 'count']);
    }
}
