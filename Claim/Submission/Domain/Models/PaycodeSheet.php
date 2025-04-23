<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Model;

class PaycodeSheet extends Model
{
    protected $table = 'paycode_sheets';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'cpt_codes_combo_id',
        'provider_id',
        'fqhc_center_id',
        'rate',
        'rate_multiplicator',
    ];

    public function cptCodesCombo(): HasOne
    {
        return $this->hasOne(CptCodesCombo::class,'id');
    }

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class,'id');
    }

    public function center(): HasOne
    {
        return $this->hasOne(Center::class,'id');
    }

    public function rate(): float
    {
        return $this->rate;
    }

    public function rateMultiplicator(): float
    {
        return $this->rate_multiplicator;
    }

}



