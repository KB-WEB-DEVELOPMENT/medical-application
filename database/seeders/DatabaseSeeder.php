<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
 
        /* 
           If, to save time, you do not want to run every single seeder individually,
           you can run this DatabaseSeeder and accompany them with 
           follow-up step 1/3, follow-up step 2/3 and follow-up step 3/3 below. 
        */

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            FqhcCenterSeeder::class,
            ProviderSeeder::class,
            PatientSeeder::class,
            ClaimStatusSeeder::class,
            ApplicationUserSeeder::class,
            ClaimSeeder::class,
            PaycodeSheetSeeder::class,
            ProgressNoteSeeder::class,                                    
        ]);

        /*
            Follow-up step 1/3: 
            
            In the terminal, type: php artisan import:CPTCodes2025 

            Follow-up step 2/3:

            In the terminal, type: php artisan db:seed --class=CptCodesComboSeeder

            Follow-up step 3/3:

            In the terminal, type: php artisan db:seed --class=CptCodesComboLookupSeeder

        */

    }
}