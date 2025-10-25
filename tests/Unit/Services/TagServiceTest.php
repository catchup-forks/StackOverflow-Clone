<?php

namespace Tests\Unit\Services;

use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TagServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_tag(): void
    {
        /** @Arrange */
        $service = new TagService();

        /** @Act */
        $tag = $service->create([
            'name' => 'phpunit',
            'count' => 10,
        ]);

        /** @Assert */
        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'name' => 'phpunit']);
    }

    #[Test]
    public function it_finds_a_tag_by_id(): void
    {
        /** @Arrange */
        $service = new TagService();
        $tag = Tag::factory()->create();

        /** @Act */
        $found = $service->find($tag->id);

        /** @Assert */
        $this->assertEquals($tag->id, $found->id);
    }

    #[Test]
    public function it_updates_a_tag(): void
    {
        /** @Arrange */
        $service = new TagService();
        $tag = Tag::factory()->create();

        /** @Act */
        $updated = $service->update($tag, ['name' => 'laravel', 'count' => 20]);

        /** @Assert */
        $this->assertEquals('laravel', $updated->name);
    }

    #[Test]
    public function it_deletes_a_tag(): void
    {
        /** @Arrange */
        $service = new TagService();
        $tag = Tag::factory()->create();

        /** @Act */
        $service->delete($tag);

        /** @Assert */
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    #[Test]
    public function it_returns_ids_by_names(): void
    {
        /** @Arrange */
        $service = new TagService();
        $tags = Tag::factory()->count(2)->create();

        /** @Act */
        $ids = $service->idsByNames($tags->pluck('name')->all());

        /** @Assert */
        sort($ids);
        $this->assertEquals($tags->pluck('id')->sort()->values()->all(), $ids);
    }
}
