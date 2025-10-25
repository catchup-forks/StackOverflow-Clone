<?php

namespace Tests\Feature\Filament\Admin;

use App\Enums\VoteType;
use App\Filament\Admin\Resources\VoteResource\Pages\ListVotes;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ListVotes::class)]
class VoteResourceCrudTest extends AdminPanelTestCase
{
    #[Test]
    public function admin_can_create_votes_via_modal(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $voter = User::factory()->create();

        Livewire::test(ListVotes::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $voter->id,
                'vote_type_id' => VoteType::UpVote->value,
                'bounty_amount' => 50,
                'creation_date' => Carbon::parse('2024-02-14 07:45')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('votes', [
            'post_id' => $post->id,
            'user_id' => $voter->id,
            'vote_type_id' => VoteType::UpVote->value,
            'bounty_amount' => 50,
        ]);
    }

    #[Test]
    public function admin_can_update_votes_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $vote = Vote::factory()->create([
            'vote_type_id' => VoteType::UpVote->value,
            'bounty_amount' => 0,
        ]);

        Livewire::test(ListVotes::class)
            ->callTableAction('edit', $vote->getKey(), data: [
                'post_id' => $vote->post_id,
                'user_id' => $vote->user_id,
                'vote_type_id' => VoteType::DownVote->value,
                'bounty_amount' => 100,
                'creation_date' => Carbon::parse('2024-03-01 10:30')->format('Y-m-d H:i'),
            ])
            ->assertHasNoActionErrors();

        $vote->refresh();

        $this->assertSame(VoteType::DownVote->value, $vote->vote_type_id);
        $this->assertSame(100, $vote->bounty_amount);
    }

    #[Test]
    public function admin_can_delete_votes_from_table_modal(): void
    {
        $this->actingAsAdmin();

        $vote = Vote::factory()->create();

        Livewire::test(ListVotes::class)
            ->callTableAction('delete', $vote->getKey())
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('votes', ['id' => $vote->id]);
    }

    #[Test]
    public function vote_creation_requires_vote_type(): void
    {
        $this->actingAsAdmin();

        $post = Post::factory()->create();
        $voter = User::factory()->create();

        Livewire::test(ListVotes::class)
            ->callAction('create', data: [
                'post_id' => $post->id,
                'user_id' => $voter->id,
                'vote_type_id' => null,
                'creation_date' => Carbon::now()->format('Y-m-d H:i'),
            ])
            ->assertHasActionErrors(['vote_type_id']);
    }
}
