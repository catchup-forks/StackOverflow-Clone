<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('post_types')->delete();

        $now = Carbon::now();

        $posttypes = [
            [
                'id' => 1,
                'name' => 'Question',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Answer',
                'updated_at' => $now,
                'created_at' => $now,
            ],
        ];

        DB::table('post_types')->insert($posttypes);
    }
}
