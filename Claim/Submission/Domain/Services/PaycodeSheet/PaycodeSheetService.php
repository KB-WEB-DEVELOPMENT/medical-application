<?php

namespace Claim\Submission\Domain\Services\PaycodeSheet;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Claim\Submission\Domain\Exceptions\CptCodeNotFoundException;
use Claim\Submission\Domain\Exceptions\InvalidByProviderQuery;

use Claim\Submission\Domain\Services\Contracts\PaycodeSheetServiceInterface;

use Claim\Submission\Domain\Models\PaycodeSheet;
use Claim\Submission\Domain\Models\Provider;
use Claim\Submission\Domain\Models\Center;


use Claim\Submission\Domain\Models\CptCode;
use Claim\Submission\Domain\Models\CptCodesCombo;
use Claim\Submission\Domain\Models\CptCodesComboLookup;

class PaycodeSheetService implements PaycodeSheetServiceInterface
{

    public function paycodeSheetRowEntryExists(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): bool
    {
        return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                                ->where('provider_id',$provider_id)
                                ->where('fqhc_center_id',$fqhc_center_id)
                                ->exists();
    }

    public function cptCodesCombo(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?CptCodesCombo
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);
    
        if ($exists) {

            return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->cptCodesCombo;
        
        } 

        return null;
    }

    public function comboCptCodes(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): array
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            $cptCodesCombo = PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->cptCodesCombo;
        
            return $cptCodesCombo->cptCodes->toArray();               
        }
        
        $empty = [];
        
        return $empty;

    }

    public function cptCodeBelongsToRowEntry(string $cpt_code,int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): bool
    {
        $cptCodeExists =  CptCode::where('cpt_code',$cpt_code)->exists();

        if (!$cptCodeExists) {

            throw new CptCodeNotFoundException();

        }
                
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            $cptCodesCombo = PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->cptCodesCombo;
        
            $cptCodesInComboArray =  $cptCodesCombo->cptCodes->toArray();               
                
            return in_array($cpt_code,$cptCodesInComboArray);
        }

        return false;

    }

    public function provider(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?Provider
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->provider;
        
        } 

        return null;

    }

    public function center(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?Center
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->center;
        
        } 

        return null;

    }

    public function rate(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?float
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->rate();        
        } 

        return null;


    }

    public function rateMultiplicator(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?float
    {
        $exists = $this->paycodeSheetRowEntryExists($cpt_codes_combo_id,$provider_id,$fqhc_center_id);

        if ($exists) {

            return PaycodeSheet::where('cpt_codes_combo_id',$cpt_codes_combo_id)
                               ->where('provider_id',$provider_id)
                               ->where('fqhc_center_id',$fqhc_center_id)
                               ->rateMultiplicator();        
        } 

        return null;

    }

    public function byProvider(null|int $provider_id = null,null|string $npi_number = null): Collection
    {
        $count = 0;

        if (is_null($provider_id))
            $count++;
        
        if ( (is_null($npi_number)) or (strlen($npi_number) == 0) ) 
            $count++;
            
        if ($count != 1) {

            throw new InvalidByProviderQuery();
        }

        if (!is_null($provider_id)) {
            
            $exists = PaycodeSheet::where('provider_id',$provider_id)->exists(); 

            if ($exists) {

                return PaycodeSheet::where('provider_id',$provider_id)->orderBy('id','asc')->get();
    
            } 
        	
            $emptyCollection = collect();
        
            return $emptyCollection;
        }
        
        if (!is_null($npi_number)) {
            
            $exists = Provider::where('npi_number',$npi_number)->exists(); 

            if ($exists) {

                $provider_id = (int)Provider::where('npi_number',$npi_number)->get(['id']);

                return PaycodeSheet::where('provider_id',$provider_id)->orderBy('id','asc')->get();
    
            } 
        	
            $emptyCollection = collect();
        
            return $emptyCollection;
        }
    }

    public function byCenter(int $fqhc_center_id): Collection
    {
        $exists = Center::where('id',$fqhc_center_id)->exists(); 

        if ($exists) {

            return PaycodeSheet::where('fqhc_center_id',$fqhc_center_id)->orderBy('id','asc')->get();

        } 
        
        $emptyCollection = collect();
    
        return $emptyCollection;
    }

}