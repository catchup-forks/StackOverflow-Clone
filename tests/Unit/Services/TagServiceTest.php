<?php

namespace Tests\Unit\Services;

use App\Services\TagService;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(TagService::class)]
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

    #[Test]
    public function it_requires_a_tag_name_when_creating(): void
    {
        /** @Arrange */
        $service = new TagService();

        /** @Assert */
        $this->expectException(InvalidArgumentException::class);

        /** @Act */
        $service->create(['count' => 0]);
    }

    #[Test]
    public function it_throws_when_tag_not_found(): void
    {
        /** @Arrange */
        $service = new TagService();

        /** @Assert */
        $this->expectException(ModelNotFoundException::class);

        /** @Act */
        $service->find(999);
    }
}
