<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagSynonym extends Model
{
    protected $table = 'tag_synonyms';

    protected $guarded = [];

    public static array $rules = [];
}
