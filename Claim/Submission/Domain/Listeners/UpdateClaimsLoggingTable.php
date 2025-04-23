<?php
 
namespace Claim\Submission\Domain\Listeners;

use Claim\Submission\Domain\Events\ClaimWasCreated;
use Claim\Submission\Domain\Events\ClaimWasUpdated;
use Claim\Submission\Domain\Events\ClaimWasDeleted;

use Illuminate\Support\Facades\DB;

class UpdateClaimsLoggingTable
{

    public function __construct() {}
 
    public function handle(ClaimWasCreated|ClaimWasUpdated|ClaimWasDeleted $event): void
    {
        $event_name = (new \ReflectionClass($event))->getShortName();
        
        $claim = isset($event->claim) ? $event->claim : null;

        $claim_id = isset($claim) ? $claim->id : $event->deleted_claim_id;

        $event_doer_user = $event->appUser->user;

        $event_doer_user_id = $event_doer_user->id;
    
        DB::table('claims_logging')->insert([
            'event_name' => $event_name,
            'claim_id' => $claim_id,
            'event_doer_user_id' => $event_doer_user_id,
        ]);
    }
}