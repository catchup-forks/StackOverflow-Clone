<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->delete();

        $now = Carbon::now();

        $posts = [
            [
                'id' => 1,
                'post_type_id' => '1',
                'accepted_answer_id' => '',
                'parent_id' => '',
                'creation_date' => $now,
                'score' => '2',
                'view_count' => '5',
                'body' => 'How do you loop throught a PHP array?',
                'user_id' => 1,
                'owner_display_name' => 'JohnDoe01',
                'last_editor_user_id' => '',
                'last_editor_display_name' => '',
                'last_edit_date' => $now,
                'last_activity_date' => $now,
                'title' => 'PHP array looping?',
                'tags' => 'php, php-5',
                'answer_count' => '0',
                'comment_count' => '1',
                'favorite_count' => '1',
                'closed_date' => $now,
                'community_owned_date' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'post_type_id' => '1',
                'accepted_answer_id' => '3',
                'parent_id' => '',
                'creation_date' => $now,
                'score' => '4',
                'view_count' => '15',
                'body' => 'How do you use a foreach loop PHP?',
                'user_id' => 2,
                'owner_display_name' => 'JaneDoe01',
                'last_editor_user_id' => '',
                'last_editor_display_name' => '',
                'last_edit_date' => $now,
                'last_activity_date' => $now,
                'title' => 'PHP foreach looping?',
                'tags' => 'php, php-5',
                'answer_count' => '2',
                'comment_count' => '1',
                'favorite_count' => '1',
                'closed_date' => $now,
                'community_owned_date' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'id' => 3,
                'post_type_id' => '2',
                'accepted_answer_id' => '',
                'parent_id' => '2',
                'creation_date' => $now,
                'score' => '4',
                'view_count' => '15',
                'body' => 'Like so; foreach($array as $element){}.',
                'user_id' => 1,
                'owner_display_name' => 'JohnDoe01',
                'last_editor_user_id' => '',
                'last_editor_display_name' => '',
                'last_edit_date' => $now,
                'last_activity_date' => $now,
                'title' => '',
                'tags' => '',
                'answer_count' => '0',
                'comment_count' => '0',
                'favorite_count' => '0',
                'closed_date' => $now,
                'community_owned_date' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'id' => 4,
                'post_type_id' => '2',
                'accepted_answer_id' => '',
                'parent_id' => '2',
                'creation_date' => $now,
                'score' => '1',
                'view_count' => '5',
                'body' => 'Like so; for($i = 0; $1 < 5; $i++){}.',
                'user_id' => 1,
                'owner_display_name' => 'JohnDoe01',
                'last_editor_user_id' => '',
                'last_editor_display_name' => '',
                'last_edit_date' => $now,
                'last_activity_date' => $now,
                'title' => '',
                'tags' => '',
                'answer_count' => '0',
                'comment_count' => '0',
                'favorite_count' => '0',
                'closed_date' => $now,
                'community_owned_date' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ],
        ];

        DB::table('posts')->insert($posts);
    }
}
