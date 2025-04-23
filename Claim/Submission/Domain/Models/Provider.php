<?php

namespace Claim\Submission\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use Notifiable; 
    
    protected $table = 'providers';

    protected $primaryKey = 'id';  // uneeded, only there for enhanced understanding.
    
    protected $fillable = ['npi_number'];
    
    public function npiNumber(): string
    {
        return $this->npi_number;
    }
}    

