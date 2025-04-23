<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimStatus extends Model
{
    protected $table = 'claim_status';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'name',
        'slug',
        'code',
    ];

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function code(): string
    {
        return (string)$this->code;
    }
}
