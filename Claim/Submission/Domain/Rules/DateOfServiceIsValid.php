<?php

namespace Claim\Submission\Domain\Rules;

use Claim\Validation\Domain\Exceptions\InvalidDateOfServiceException;
use Claim\Submission\Domain\Exceptions\DateOfServiceExpiredException; 

use Illuminate\Contracts\Validation\Rule;

use Claim\Submission\Domain\Models\PaycodeSheet; 

class DateOfServiceIsValid implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $dos = $this->request['date_of_service'];

        $dos_dt = DateTime::createFromFormat('m-d-Y',$dos)->format('m-d-Y');

        if (!$dos_dt) {
            throw new InvalidDateOfServiceException();     
        }

        $now_dt = new \DateTime('now');

        $latest_dt = $now_dt->modify('-1 year');

        return ($dos_dt < $latest_dt) ? false : true; 
    }    

    public function message()
    {
        return 'You are submitting a claim for a service more than a year after it was performed.
        This goes against the rules of US Federally Qualified Health Centers (FQHCs).';
    }
}