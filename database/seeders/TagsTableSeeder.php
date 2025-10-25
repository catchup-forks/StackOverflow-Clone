<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tags')->delete();

        $now = Carbon::now();

        $tags = [
            [
                'id' => 1,
                'name' => 'Tag 1',
                'count' => '1',
                'excerpt_post_id' => '',
                'wiki_post_id' => '',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Tag 2',
                'count' => '1',
                'excerpt_post_id' => '',
                'wiki_post_id' => '',
                'updated_at' => $now,
                'created_at' => $now,
            ],
        ];

        DB::table('tags')->insert($tags);
    }
}
