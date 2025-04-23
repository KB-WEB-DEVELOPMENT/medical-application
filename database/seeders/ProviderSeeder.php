<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('providers')->insert([
            'npi_number' => '1234567890 ',
        ]);

        DB::table('providers')->insert([
            'npi_number' => '9876543210',
        ]);
    }
}