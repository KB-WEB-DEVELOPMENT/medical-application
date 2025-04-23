<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('claim_status')->insert([
            'name' => 'Pending review',
            'slug' => 'pending-review',
            'code' => 'PENDING_REVIEW',
        ]);

        DB::table('claim_status')->insert([
            'name' => 'Reviewer approved',
            'slug' => 'reviewer-approved',
            'code' => 'REVIEWER_APPROVED',
        ]);

        DB::table('claim_status')->insert([
            'name' => 'Correction needed',
            'slug' => 'correction-needed',
            'code' => 'CORRECTION_NEEDED',
        ]);

        DB::table('claim_status')->insert([
            'name' => 'Biller correction needed',
            'slug' => 'biller-correction-needed',
            'code' => 'BILLER_CORRECTION_NEEDED',
        ]);

        DB::table('claim_status')->insert([
            'name' => 'Biller approved',
            'slug' => 'biller-approved',
            'code' => 'BILLER_APPROVED',
        ]);

    }
}