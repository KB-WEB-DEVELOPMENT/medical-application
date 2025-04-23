<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Claim\Submission\Domain\Services\Contracts\PaycodeSheetServiceInterface;
use Claim\Submission\Domain\Services\PaycodeSheet\PaycodeSheetService;

class PaycodeSheetServiceProvider extends ServiceProvider
{

    
    public function register(): void
    {
        $this->app->bind(PaycodeSheetServiceInterface::class, PaycodeSheetService::class);
        
    }

    public function boot(): void
    {

    }
}