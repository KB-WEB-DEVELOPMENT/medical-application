<?php

namespace Claim\Submission\Domain\Rules;

use Illuminate\Contracts\Validation\Rule;

use Claim\Submission\Domain\Models\PaycodeSheet; 

class ProviderCptCodesComboExists implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $cpt_code_combo_id = (int)$this->request['cpt_code_combo_id'];
        $provider_id = (int)$this->request['provider_id'];   
        
        $exists = PaycodeSheet::where('cpt_code_combo_id',$cpt_code_combo_id)->where('provider_id',$provider_id)->exists();
        
        return $exists; 
    }    

    public function message()
    {
        return 'This combination [provider - CPT code combo] does not exist in our database.';
    }
}