<?php

namespace Claim\Submission\Domain\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CptCodesCombo extends Model
{
    protected $table = 'cpt_codes_combos';  
    
    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'cpt_codes_combo',
    ];

    protected function casts(): array
    {
        return [
            'cpt_codes_combo' => 'array',
        ];
    }

    public function cptCodes(): HasManyThrough
    {
        return $this->HasManyThrough(CptCode::class,CptCodesComboLookup::class);
    }
}
