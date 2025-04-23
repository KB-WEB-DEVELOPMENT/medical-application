<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('application_users')->insert([
            'user_id' => 1,
            'role_id' => 1,
            'active' =>  true,
        ]);

        DB::table('application_users')->insert([
            'user_id' => 2,
            'role_id' => 2,
            'active' =>  true,
        ]);

        DB::table('application_users')->insert([
            'user_id' => 3,
            'role_id' => 3,
            'active' =>  true,
        ]);

        DB::table('application_users')->insert([
            'user_id' => 4,
            'role_id' => 4,
            'active' =>  true,
        ]);
    }
}