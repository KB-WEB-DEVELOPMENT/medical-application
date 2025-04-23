<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressNote extends Model
{
    protected $table = 'progress_notes';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'progress_note',
        'claim_id'
    ];

    /*
        Note that 'claim_id' acts as a foreign key in the 'progress notes' table.
        The only reason I do not explicitely set 'claim_id' as a foreign key in that table is because of
        'The chicken or the egg' causality dilemma. 
        (1) A claim can only be created if a progress note already exists.
        (2) A progress note can only be created if a claim already exists.
        I choose (1) to always be explicitely true and (2) to always be implicitely true.
        That is why 'claim_id' is not an explicit foreign key in the 'progress notes' table.
        I therefore cannot use the Laravel 'belongsTo' relationship within the ProgressNote model.
        (I could make the progress notes optional when creating a claim, to avoid the dilemna.)
    */

    public function progressNote(): string
    {
        return $this->progress_note;
    }

    public function claimId(): int
    {
        return $this->claim_id;
    }
}
