<?php
 
namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class PaymentPolicy
{

    public function viewAny(): bool
    {        
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    
    }

    /* Note: policy not actually applied in the routing file web.php (unlike 'viewAny') or anyhwere else but shown here for completion */
    public function create(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }

    /* Note: policy not actually applied in the routing file web.php (unlike 'viewAny') or anywhere else but shown here for completion */
    public function store(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }

    /* Note: policy not actually applied in the routing file web.php (unlike 'viewAny') or anywhere else but shown here for completion */
    public function edit(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }
    
    /* Note: policy not actually applied in the routing file web.php (unlike 'viewAny') or anywhere else but shown here for completion */
    public function update(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }
    
    /* Note: policy not actually applied in the routing file web.php (unlike 'viewAny') or anywhere else but shown here for completion */
    public function delete(): bool
    {
        $user = Auth::user();

        $role_name = $user->applicationUser->role_name;
        
        $policy = match($role_name) {
            'PROVIDER' => false,
            'REVIEWER' => false,
            'BILLER' => true,
            'ADMIN' => true,
        };

        return $policy;
    }    
}
