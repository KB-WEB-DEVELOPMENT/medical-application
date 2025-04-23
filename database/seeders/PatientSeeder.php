<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $emergency_contacts1 = [];
        $emergency_contacts1 = array('name' => 'test1','ssn' => '666-50-1234');

        $emergency_contacts2 = [];
        $emergency_contacts2 = array('name' => 'test2','ssn' => '777-50-1234');

 
        $emergency_contacts2 = [];
        
        DB::table('patients')->insert([
            'height' => 1.82,
            'weight' => 75,
            'date_of_birth' => '1967-10-04',
            'gender' => 'male',
            'eye_color' => 'brown',
            'hair_color' => 'black',
            'ssn' => '555-50-1234',
            'street_addess' => '1. Main Street, NY 10044',
            'emergency_contacts' => $emergency_contacts1,
            'identification_card_screenshot' => 'path/to/filename',
            'validated_id_card' => true,
            'driving_license_screenshot' => 'path/to/filename',
            'validated_driving_license' => true,
            'medi_cal_screenshot' => 'path/to/filename',
            'validated_medi_cal' => true,
            'signed_contract_screenshot' => 'path/to/filename',
            'validated_signed_contract' => true,
        ]);

        DB::table('patients')->insert([
            'height' => 1.83,
            'weight' => 76,
            'date_of_birth' => '1967-11-04',
            'gender' => 'female',
            'eye_color' => 'brown',
            'hair_color' => 'black',
            'ssn' => '888-50-1234',
            'street_addess' => '2. Main Street, NY 10044',
            'emergency_contacts' => $emergency_contacts2,
            'identification_card_screenshot' => 'path/to/filename',
            'validated_id_card' => true,
            'driving_license_screenshot' => 'path/to/filename',
            'validated_driving_license' => true,
            'medi_cal_screenshot' => 'path/to/filename',
            'validated_medi_cal' => true,
            'signed_contract_screenshot' => 'path/to/filename',
            'validated_signed_contract' => true,
        ]);

    }
}