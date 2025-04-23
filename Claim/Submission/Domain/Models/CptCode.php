<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CptCode extends Model
{
    protected $table = 'cpt_codes';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'procedure_code_category',
        'cpt_code',
        'description',
    ];

    public function cptCodesCombos(): BelongsToMany
    {
        return $this->belongsToMany(CptCodesCombo::class,'cpt_codes_combos_lookup');
    }

    public function procedureCodeCategory(): string
    {
        return (string)$this->procedure_code_category;
    }

    public function cptCode(): string
    {
        return $this->cpt_code;
    }

    public function description(): string
    {
        return (string)$this->description;
    }

}

