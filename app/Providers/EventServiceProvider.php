<?php

namespace App\Providers;

use App\Models\Badge;
use App\Models\Comment;
use App\Models\CommentUpvote;
use App\Models\Post;
use App\Models\PostFeedback;
use App\Models\PostHistory;
use App\Models\PostTag;
use App\Models\Provider;
use App\Models\SuggestEditVote;
use App\Models\SuggestedEdit;
use App\Models\SuggestedEditVote;
use App\Models\Tag;
use App\Models\TagSynonym;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Vote;
use App\Observers\BaseModelObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot(): void
    {
        $observer = BaseModelObserver::class;

        foreach ([
            Badge::class,
            Comment::class,
            CommentUpvote::class,
            Post::class,
            PostFeedback::class,
            PostHistory::class,
            PostTag::class,
            Provider::class,
            SuggestEditVote::class,
            SuggestedEdit::class,
            SuggestedEditVote::class,
            Tag::class,
            TagSynonym::class,
            User::class,
            Vote::class,
            UserProfile::class,
        ] as $model) {
            $model::observe($observer);
        }
    }
}
