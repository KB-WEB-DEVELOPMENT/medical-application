<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class CptCodesComboLookup extends Model
{
    protected $table = 'cpt_codes_combos_lookup';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'cpt_code_id',
        'cpt_codes_combo_id',
    ];

    public function cptCode(): HasOne
    {
        return $this->hasOne(CptCode::class,'cpt_code_id');
    }

    public function cptCodesCombo(): HasOne
    {
        return $this->hasOne(CptCodesCombo::class,'cpt_codes_combo_id');
    }

    #Not needed, only shown for completion. Method cptCode() above achieves the same.
    public function cptCodeId(): int
    {
        return $this->cpt_code_id;
    }

    #Not needed, only shown for completion. Method cptCodesCombo() above achieves the same.
    public function cptCodesComboId(): int
    {
        return $this->cpt_codes_combo_id;
    }

}