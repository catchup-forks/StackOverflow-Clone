<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = [];

    public function getReminderEmail(): string
    {
        return $this->email;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'user_id');
    }

    public function provider(): HasMany
    {
        return $this->hasMany(Provider::class, 'user_id');
    }

    public function badges(): HasMany
    {
        return $this->hasMany(Badge::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function postHistory(): HasMany
    {
        return $this->hasMany(PostHistory::class, 'user_id');
    }

    public function suggestedEdit(): HasMany
    {
        return $this->hasMany(SuggestedEdit::class, 'user_id');
    }

    public function suggestedEditVote(): HasMany
    {
        return $this->hasMany(SuggestedEditVote::class, 'user_id');
    }
}
