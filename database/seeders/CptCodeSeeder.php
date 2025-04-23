<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CptCodeSeeder extends Seeder
{
    public function run(): void
    {
        
    /*
       
       Note that we do not need to seed the 'cpt_codes' table since 
       we created our own Artisan command to import all table data
       from our array in file CptCodes2025.php (location :config/CptCodes2025.php)
       Our Artisan command is found at \routes\ImportCptCodes.php

    */
        
    }
}

