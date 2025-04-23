<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'provider',
            'slug' => 'provider',
        ]);

        DB::table('roles')->insert([
            'name' => 'reviewer',
            'slug' => 'reviewer',
        ]);

        DB::table('roles')->insert([
            'name' => 'biller',
            'slug' => 'biller',
        ]);


        DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => 'admin',
        ]);


    }
}