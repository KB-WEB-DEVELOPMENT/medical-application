<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Claim\Submission\Domain\Models\ProgressNote;

    /*

    See observation written in file Claim\Submission\Domain\Models\ProgressNote.php

    */

class ProgressNoteSeeder extends Seeder
{

    public function run(): void
    {
        $claim_ids = [];
        $claim_ids = [1,2,3,4,5,6,7,8,9,10];

        foreach($claim_ids as $value) {
            
            $newModel = new ProgressNote();
            $newModel->progress_note = 'progress note text for claim id ' . $value;
            $newModel->claim_id = $value;
            $newModel->save();
        }
    }
}