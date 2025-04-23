<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Claim\Submission\Domain\Models\PaycodeSheet;

class PaycodeSheetSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        
        $data = [
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,1,2,1,2,1,2,1,2],
            [2,1,2,1,2,1,2,1,2,1],
            [250.75,135.95,495.15,560.45,120.80,90.55,340.92,670.30,115.65,750.95],
            [1.05,2.55,3.70,1.45,4.90,2.95,3.55,2.35,3.95,1.10],
        ];

        $cpt_codes_combo_ids = [];
        $provider_ids = [];
        $fqhc_center_ids = [];
        $rates = [];
        $multiplicators = [];
    
        foreach($data as [$cpt_codes_combo_ids,$provider_ids,$fqhc_center_ids,$rates,$multiplicators]) {
                      
            for ($index = 0; $index <10; $index++) {
            
                $newModel = new PaycodeSheet();
                $newModel->cpt_codes_combo_id = $cpt_codes_combo_ids[$index];
                $newModel->provider_id = $provider_ids[$index];
                $newModel->fqhc_center_id = $fqhc_center_ids[$index];
                $newModel->rate = $rates[$index];
                $newModel->rate_multiplicator = $multiplicators[$index];
            
                $newModel->save();    
            } 
        
        }
    }
}
