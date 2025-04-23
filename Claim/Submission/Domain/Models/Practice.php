<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Model;

 /*
    note: This table corresponding to this model is in the book but is not actually used in the application. 
        In an ideal case, any practice would be able to register with one or more providers.
        This presupposes that practices would be OK with CPT combo rates in dollars set by each of these providers,
        as specified in the paycode_sheets table.
        I do not think that the 'one to one' relationship between a 'provider' and a 'practice' that the author
        establishes on page 226 of the book is as simple as that and correct.
 */

class Practice extends Model
{
    protected $table = 'practices';

    protected $primaryKey = 'id'; // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'name',
        'street_address',
        'state',
    ];

    public function name(): string
    {
        return $this->name;
    }

    public function streetAddress(): string
    {
        return $this->street_address;
    }

    public function state(): string
    {
        return $this->state;
    }
}