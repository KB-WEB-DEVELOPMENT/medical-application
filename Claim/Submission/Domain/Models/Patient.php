<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'height',
        'weight',
        'date_of_birth',
        'gender',
        'eye_color',
        'hair_color',
        'ssn',
        'emergency_contacts',
        'identification_card_screenshot',
        'validated_id_card',
        'driving_license_screenshot',
        'validated_driving_license',
        'medi_cal_screenshot',
        'validated_medi_cal',
        'signed_contract_screenshot',
        'validated_signed_contract',
    ];

    protected function casts(): array
    {
        return [
            'emergency_contacts' => 'array',
        ];
    }

    /*
        note: we could use Spatie Laravel Data 'data transfer object' package
        https://spatie.be/docs/laravel-data/v4/introduction to guarantee data integrity
    */
    public function patientBiologicalData(): array 
    {
        $data = [];
        $data['height'] = $this->height;
        $data['weight'] = $this->weight;
        $data['date_of_birth'] = $this->date_of_birth;
        $data['gender'] = $this->gender;
        $data['eye_color'] = $this->eye_color;
        $data['hair_color'] = $this->hair_color;
        
        return $data;
    }

    public function ssn(): string
    {
        return $this->ssn;
    }

    /*
        We assume that the patient 3 emergency contacts contact details are contained in the 
        emergency_contacts array and have been thoroughly checked.
    */
    public function emergencyContacts(): array
    {
        return is_array($this->emergency_contacts) ? $this->emergency_contacts : json_decode($this->emergency_contacts,true);
    }

    public function idCardImageName(): ?string
    {
        return $this->identification_card_screenshot;
    }

    public function idCardValidated(): bool
    {
        return $this->validated_id_card == true;
    }

    public function drivingLicenseImageName(): ?string
    {
        return $this->driving_license_screenshot;
    }

    public function drivingLicenseValidated(): bool
    {
        return $this->validated_driving_license == true;
    }

    public function mediCalImageName(): string
    {
        return $this->medi_cal_screenshot;
    }

    public function mediCalValidated(): bool
    {
        return $this->validated_medi_cal == true;
    }

    public function signedContractImageName(): string
    {
        return $this->signed_contract_screenshot;
    }

    public function signedContractValidated(): bool
    {
        return $this->validated_signed_contract == true;        
    }

    /*
        We assume that the contact details of the patient's 3 emergency contacts are contained in the 
        emergency_contacts array and have been thoroughly checked.
    */
    public function patientIdentityValidated(): bool
    {
        $check = match(true) {
            ($this->idCardValidated() && count($this->emergencyContacts()) != 0) => true,
            ($this->drivingLicenseValidated() && count($this->emergencyContacts()) != 0) => true,
            default => false,
        };
        
        return $check;
    }
}
