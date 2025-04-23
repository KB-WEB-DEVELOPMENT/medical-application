<?php

namespace Claim\Submission\Domain\Rules;

use Claim\Validation\Domain\Exceptions\InvalidPatientException;
 
use Illuminate\Contracts\Validation\Rule;

use Claim\Submission\Domain\Models\Patient; 

class PatientIsValidated implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $patient_id = $this->request['patient_id'];

        $patient =  Patient::where('id',$patient_id)->get();

        if (!$patient->patientIdentityValidated()) {
            throw new InvalidPatientException();     
        }

        if (!$patient->mediCalValidated()) {
            throw new InvalidPatientException();     
        }
        
        if (!$patient->signedContractValidated()) {
            throw new InvalidPatientException();     
        }
                
        return true;
        
    }    

    public function message()
    {
        return 'The patient credentials have not been properly validated by the system.';
    }
}