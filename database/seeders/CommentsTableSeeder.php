<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comments')->delete();

        $now = Carbon::now();

        $comments = [
            [
                'id' => 1,
                'post_id' => '1',
                'score' => '2',
                'body' => 'Using a for or foreach loop.',
                'creation_date' => $now,
                'user_display_name' => 'JaneDoe01',
                'user_id' => '2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'post_id' => '2',
                'score' => '4',
                'body' => 'Not too sure.',
                'creation_date' => $now,
                'user_display_name' => 'JohnDoe01',
                'user_id' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('comments')->insert($comments);
    }
}
