<?php 

namespace Database\Seeders;

use Claim\Submission\Domain\Models\CptCode;
use Claim\Submission\Domain\Models\CptCodesCombo;
use Claim\Submission\Domain\Models\CptCodesComboLookup;

use Illuminate\Support\Collection;

use Illuminate\Database\Seeder;

class CptCodesComboLookupSeeder extends Seeder
{
    public function run(): void
    {
        $cptCodeModel = CptCode::all();
        $cptCodeArray = [];
        $cptCodeArray = $cptCodeModel->get(['id','cpt_code'])->toArray();

        $cptCodesComboModel = CptCodesCombo::all();
        $cptCodesComboArray = [];
        $cptCodesComboArray =  $cptCodesComboModel->get(['id','cpt_codes_combo'])->toArray();


        $cptCodesComboLookupArray= [];

        foreach($cptCodeArray as $key1 => $val1) {
            
            foreach($cptCodesComboArray as $key2 => $val2) {
             
                if (in_array($val1['cpt_code'],$val2['cpt_codes_combo'])) {

                    $cptCodesComboLookupArray['cpt_code_id'] = $val1['id'];
                    $cptCodesComboLookupArray['cpt_codes_combo_id'] = $val2['id'];

                } 
            }

        }

        foreach($cptCodesComboLookupArray as $arr) {
            
            $newModel = new CptCodesComboLookup();
            $newModel->cpt_code_id = $arr['cpt_code_id'];
            $newModel->cpt_codes_combo_id = $arr['cpt_codes_combo_id'];
            $newModel->save();
        }

    }
}