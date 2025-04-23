<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
 
use Claim\Validation\Domain\Exceptions\PatientNotFoundException; 
use Claim\Validation\Domain\Exceptions\ProviderNotFoundException; 
use Claim\Validation\Domain\Exceptions\InvalidSubmittedWithinDatesException; 
use Claim\Validation\Domain\Exceptions\ClaimStatusNotFoundException; 

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Claim\Submission\Domain\Events\ClaimWasCreated; 
use Claim\Submission\Domain\events\ClaimWasUpdated; 
use Claim\Submission\Domain\events\ClaimWasDeleted; 
use Illuminate\Notifications\Notifiable;

class Claim extends Model
{
    use Notifiable; 
    
    protected $table = 'claims';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.
    
    protected $fillable = ['provider_id','patient_id','cpt_codes_combo_id','progress_note_id','status_id',
                          'date_of_service'];
    
    protected $dispatchesEvents = [
        'created' => ClaimWasCreated::class,
        'updated' => ClaimWasUpdated::class,
        'deleted' => ClaimWasDeleted::class,
        /*        
        other potential events (see book): BillerHasApprovedClaim,PatientDocumentsUploaded,
        PatientEligibilityVerified, PatientUpdatedPrimaryProvider, PatientWasRegistered
        ProviderAddedToPaycodeSheet, ProviderUpdatedCptCodesGroups, ProviderWasPaid, ProviderWasRegistered
        */
        ];

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class,'id');
    }        
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class,'id');
    }

    public function cptCodesCombo(): HasOne
    {
        return $this->hasOne(CptCodesCombo::class,'id');
    }

    public function progressNote(): HasOne
    {
        return $this->hasOne(ProgressNote::class,'id');
    }
    
    public function claimStatus(): HasOne
    {
        return $this->hasOne(ClaimStatus::class,'id');
    }

    public function dateOfService(): Object
    {
        return $this->date_of_service; // DateTime
    }

    /*
    We know that every registered health care provider in the US
    must have a unique NPI number (see provider model/migration table)
    (1) Instead of using the primitive type string, I could create a NPI number value object and 
        use this value object to type hint $npi_number.
    (2) There exists also various tentative paying APIs which allow developers to retrieve
        providers data based on the NPI number.
    https://en.wikipedia.org/wiki/National_Provider_Identifier 
    https://en.wikipedia.org/wiki/Luhn_algorithm
    */

    #[Scope]
    public function filterByProvider(Builder $query,string $npi_number): void
    {
        $provider =  Provider::where('npi_number',$npi_number)->get();

        if ($provider->isEmpty()) {

            throw new ProviderNotFoundException(); 
        }
               
        $query->where('provider_id','=',$provider->id);
    }

    /* 
        Different ways which describe how $type could be type hinted:
            
        1. value object
        2. enum class
        3. string

        We choose option 3.
    */

    #[Scope]
    public function filterByStatus(Builder $query,string $type): void
    {
        $allowed_types = [];
        $allowed_types = ['PENDING_REVIEW','REVIEWER_APPROVED','CORRECTION_NEEDED',
                        'BILLER_CORRECTION_NEEDED','BILLER_APPROVED'];

        if (!in_array($type,$allowed_types)) {
            throw new ClaimStatusNotFoundException(); 
        }                

        $claim_status =  ClaimStatus::where('code',$type)->get(); 
        
        $query->where('status_id','=',$claim_status->id);

    }

    #[Scope]    
    public function submittedWithinDates(Builder $query,string|null $from = null,string|null $to = null): void
    {
        if (!is_null($from)) {
            $from_dt = DateTime::createFromFormat('m-d-Y',$from)->format('m-d-Y');
        }
        
        if (!is_null($to)) {
            $to_dt = DateTime::createFromFormat('m-d-Y',$to)->format('m-d-Y');
        }
        
        if ((isset($from_dt) && (!$from_dt)) || (isset($to_dt) && (!$to_dt))) {
            throw new InvalidSubmittedWithinDatesException();
        }

        if (isset($from_dt) && isset($to_dt)) {

            $from_tmp = strtotime($from_dt);
            $to_tmp = strtotime($to_dt);
            $current_tmp = time();
         
            if (($from_tmp >= $to_tmp) || ($to_tmp > $current_tmp)) {
                throw new InvalidSubmittedWithinDatesException();     
            }
        }

        $specs = [];

        $specs = match (true) {
            isset($from_dt) && isset($to_dt) => array('from-to',$from_dt,$to_dt),
            isset($from_dt) && !isset($to_dt) => array('from',$from_dt),
            !isset($from_dt) && isset($to_dt) => array('to',$to_dt),
            !isset($from_dt) && !isset($to_dt) => array('all'),
        };

        if ($specs[0] === 'from-to')
            $query->whereBetween('date_of_service','=',[$specs[1],$specs[2]]);

        if ($specs[0] === 'from')
            $query->where('date_of_service','>=',$specs[1]);    
        
        if ($specs[0] === 'to')
            $query->where('date_of_service','<=',$specs[1]); 
        
        if ($specs[0] === 'all')
            $query->where('date_of_service','>=',(new DateTime())->setTimestamp(0));    

    }

    /*
    We know that 99.99 % of patients in the US are likely to be uniquely identified
    in the system by their social security number ssn (see patient model/migration table)
    Instead of the primitive data type string, I could create a ssn value object and use this value object to 
    type hint $ssn (or alternatively pay for ssn API services)
    https://www.ssa.gov/history/ssn/geocard.html 
    */

    #[Scope]
    public function filterByPatient(Builder $query,string $ssn): void
    {
        $patient =  Patient::where('ssn',$ssn)->get();

        if ($patient->isEmpty()) {

            throw new PatientNotFoundException(); 
        }
               
        $query->where('patient_id','=',$patient->id);
    }
}