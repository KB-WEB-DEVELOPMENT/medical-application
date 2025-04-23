<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FqhcCenterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fqhc_centers')->insert([
            'name' => 'FQHC Center 1',
        ]);

        DB::table('fqhc_centers')->insert([
            'name' => 'FQHC Center 2',
        ]);
    }
}