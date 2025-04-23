<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Claim\Submission\Domain\Models\Claim;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $dos1 = DateTime::createFromFormat('Y-m-d','2014-02-15')->format('m-d-Y');
        $dos2 = DateTime::createFromFormat('Y-m-d','2015-03-16')->format('m-d-Y');
        $dos3 = DateTime::createFromFormat('Y-m-d','2016-04-17')->format('m-d-Y');
        $dos4 = DateTime::createFromFormat('Y-m-d','2017-05-18')->format('m-d-Y');
        $dos5 = DateTime::createFromFormat('Y-m-d','2018-06-19')->format('m-d-Y');
        $dos6 = DateTime::createFromFormat('Y-m-d','2019-07-20')->format('m-d-Y');
        $dos7 = DateTime::createFromFormat('Y-m-d','2020-08-21')->format('m-d-Y');
        $dos8 = DateTime::createFromFormat('Y-m-d','2021-09-22')->format('m-d-Y');
        $dos9 = DateTime::createFromFormat('Y-m-d','2022-10-23')->format('m-d-Y');
        $dos10 = DateTime::createFromFormat('Y-m-d','2023-11-24')->format('m-d-Y');
        
        $data = [];

        $data = [
            [1,2,1,2,1,2,1,2,1,2],
            [1,2,1,2,1,2,1,2,1,2],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,1,2,3,4,5],
            [$dos1,$dos2,$dos3,$dos4,$dos5,$dos6,$dos7,$dos8,$dos9,$dos10],
        ];

        $provider_ids = [];
        $patient_ids = [];
        $cpt_codes_combo_ids = [];
        $progress_note_ids = [];
        $status_ids = [];
        $dates_of_service = [];
 
        foreach($data as [$provider_ids,$patient_ids,$cpt_codes_combo_ids,$progress_note_ids,$status_ids,$dates_of_service]) {
                      
            for ($index = 0; $index <10; $index++) {
            
                $newModel = new Claim();
                $newModel->provider_id = $provider_ids[$index];
                $newModel->patient_id = $patient_ids[$index];
                $newModel->cpt_codes_combo_id = $cpt_codes_combo_ids[$index];
                $newModel->progress_note_id = $progress_note_ids[$index];
                $newModel->status_id = $status_ids[$index];
                $newModel->date_of_service = $dates_of_service[$index];
            
                $newModel->save();    
            } 
        
        }
    }
}

