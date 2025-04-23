<?php

namespace Auth\Application\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Role;

class ApplicationUser extends User
{

    protected $table = 'application_users';

    protected $primaryKey = 'application_user_id'; // uneeded, only there for enhanced understanding.

    protected $fillable = [
        'user_id',
        'role_id',
        'active',
    ];

    public function user(): HasOne
    {
        return $this->belongsTo(User::class,'id');
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class,'id');
    }

    public function isActive(): bool
    {
        return (bool)$this->active == true;
    }

    public function makeActive(): void
    {
        $this->active == true;
    }

    public function makeInactive(): void
    {
        $this->active  == false;
    }

    // example: $role_str = $user->role_name 
    public function getRoleNameAttribute(): string
    {
        $role_name = match ($this->role_id) {
            1 => 'PROVIDER',
            2 => 'REVIEWER',
            3 => 'BILLER',
            4 => 'ADMIN',
        };

        return $role_name;
    }
}
