<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $table = 'fqhc_centers';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'name',
    ];

    public function name(): string
    {
        return $this->name;
    }
}
