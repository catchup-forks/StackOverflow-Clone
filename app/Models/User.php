<?php

namespace App\Models;

use App\Models\Concerns\BelongsToFranchise;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel implements AuthenticatableContract
{
    use Authenticatable;
    use BelongsToFranchise;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    public $timestamps = false;

    protected $casts = [];

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected string $guard_name = 'web';

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    #endregion
    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    #endregion
    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    #endregion
    #region Mutators
    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    #endregion
    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #endregion
    #region Factory
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */
    #endregion
}
