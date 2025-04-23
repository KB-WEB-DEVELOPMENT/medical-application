<?php

namespace Claim\Billing\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Claim\Submission\Domain\Models\Claim;
use Claim\Submission\Domain\Models\PaycodeSheet;
use Claim\Billing\Domain\Models\Payment;

/* PaycodeSheetServiceInterface used here only to show how a service could be injected into a controller through its interface */
use Claim\Submission\Domain\Services\Contracts\PaycodeSheetServiceInterface; 
/* PaycodeSheetService used here only to show how a service could be injected into a controller */
use Claim\Submission\Domain\Services\PaycodeSheet\PaycodeSheetService;

use Illuminate\View\View;

class BillingController extends Controller
{

    public function __construct(
		public Payment $payment,
		// Option 1 (Service injection through  its interface in the constructor): public PaycodeSheetServiceInterface $paycodeSheetService,
		// Option 2 (Service injection directly into the constructor): public PaycodeSheetService $paycodeShetService 
	){}
	
	public function index(): View
	{
		$payments = Payment::with('id')->orderByDesc('updated_at')->paginate(10);

		# We check for existence in the view. Through Eloquent relationships, we get all payments related data in the view. 
	
		return view('payments.index',['payments' => $payments]);
	}

    public function amountBilled(int $claim_id,int $payment_type_id): View
	{
		$claims = Claim::all();

        if ($claims->findOrFail($claim_id) instanceof ModelNotFoundException) 
        {
            throw new ClaimNotFoundException();
        }
		
		$claim = Claim::find($claim_id)->get();

		$amount = $this->payment->claimAmountBilled($claim_id,$payment_type_id);

		return view('payments.amount-billed',['claim' => $claim,'amount' => $amount,'payment_type_id' => $payment_type_id]);
	}

    public function byAmountRangeAndOrPaymentType(int|null $minAmount = null,int|null $maxAmount = null,int|null $payment_type_id = null): View
	{
		$payments = Payment::filterByAmountRangeAndOrPaymentType(minAmount:$minAmount,maxAmount:$maxAmount,payment_type_id:$payment_type_id)->orderBy('created_at','asc')->paginate(10);
	   
		return view('payments.filter-amount-range-payment-type', 
				['payments' => $payments,'minAmount' => $minAmount,'maxAmount' => $maxAmount,'payment_type_id' => $payment_type_id]);
	}

    public function byDateInterval(string|null $from = null,string|null $to = null): View
	{
		$payments = Payment::filterByBilledWithinDates(from:$from,to:$to)->orderBy('created_at','asc')->paginate(10);

		return view('payments.filter-dates-interval',['payments' => $payments,'from' => $from,'to' => $to]);

	}
}