<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // not needed
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use  Claim\Submission\Domain\Models\Claim;
use  Claim\Billing\Domain\Models\Payment;

use App\Policies\ClaimPolicy;
use App\Policies\PaymentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Claim::class => ClaimPolicy::class,
        Payment::class => PaymentPolicy::class,
    ];

    protected function resourcePolicyMap()
    {
        return [
            'Claim\Submission\Domain\Models\Claim' => 'App\Policies\ClaimPolicy',
            'Claim\Billing\Domain\Models\Payment'  => 'App\Policies\PaymentPolicy',
        ];
    
    }

   public function boot()
   {
       $this->registerPolicies();

       /*
            We don't need to specifiy this. Policies have already been specified.

            Gate::guessPolicyNamesUsing(function ($modelClass) {
                // Returns the policy class name manually
            });
        */
   }
}