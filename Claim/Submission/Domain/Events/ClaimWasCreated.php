<?php
 
namespace Claim\Submission\Domain\Events;

use Auth\Application\Models\ApplicationUser;
 
use Claim\Submission\Domain\Models\Claim;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
 
class ClaimWasCreated
{

    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Claim $claim,
        public ApplicationUser $appUser,
    ) {}
}