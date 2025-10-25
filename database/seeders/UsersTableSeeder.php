<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            [
                'id' => 1,
                'reputation' => '50',
                'creation_date' => Carbon::now(),
                'display_name' => 'John Doe',
                'last_access_date' => Carbon::now(),
                'website_url' => 'http://www.johndoe.com',
                'location' => 'New Zealand',
                'about_me' => 'Im a C++ programmer',
                'views' => '122',
                'up_votes' => '11',
                'down_votes' => '1',
                'email' => 'johndoe@email.com',
                'age' => '44',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'reputation' => '35',
                'creation_date' => Carbon::now(),
                'display_name' => 'Jane Doe',
                'last_access_date' => Carbon::now(),
                'website_url' => 'http://www.janedoe.com',
                'location' => 'New Zealand',
                'about_me' => 'Im a Python programmer',
                'views' => '108',
                'up_votes' => '19',
                'down_votes' => '2',
                'email' => 'janedoe@email.com',
                'age' => '38',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
