<?php
 
namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class ClaimPolicy
{

    public function viewAny(): bool
    {        
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => true,
            'REVIEWER' => true,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    
    }

    public function create(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => true,
            'REVIEWER' => false,
            'BILLER' => false,
            'ADMIN' => true,
        };

        return $policy;
    }

    public function store(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => true,
            'REVIEWER' => false,
            'BILLER' => false,
            'ADMIN' => true,
        };

        return $policy;
    }

    public function edit(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => true,
            'REVIEWER' => true,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }
    
    public function update(): bool
    {
        $user = Auth::user();
        
        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => true,
            'REVIEWER' => true,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }
    
    public function delete(): bool
    {
        $user = Auth::user();
        
        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => false,
            'ADMIN' => true,
        };

        return $policy;
    }    
}
