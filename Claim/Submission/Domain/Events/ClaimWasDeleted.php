<?php
 
namespace Claim\Submission\Domain\Events;

use Auth\Application\Models\ApplicationUser;
 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
 
class ClaimWasDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $deleted_claim_id,
        public ApplicationUser  $appUser,
    ) {}
}