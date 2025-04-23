<?php

namespace Claim\Submission\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Domain\Submission\App\Http\Requests\CreateClaimRequest;
use Domain\Submission\App\Http\Requests\UpdateClaimRequest;

use Auth\Application\Models\ApplicationUser;
use Auth\Application\Models\User;

use Claim\Submission\Domain\Models\Claim;
use Claim\Submission\Domain\Models\ProgressNote;
use Claim\Submission\Domain\Models\PaycodeSheet;

use Claim\Submission\Domain\Events\ClaimWasCreated;
use Claim\Submission\Domain\Events\ClaimWasUpdated;
use Claim\Validation\Domain\Exceptions\ClaimNotFoundException;

use Illuminate\View\View;

class SubmissionClaimController extends Controller
{
	public function index(): View
	{
		$claims = Claim::with('id')->orderByDesc('updated_at')->paginate(10);

		/*
		   note : We check for existence in the view. Through Eloquent relationships, we get all claims
		   related data in the view 
		*/
		return view('claims.index',['claims' => $claims]);

	}
	
	public function create(): View
	{
		return view('claims.create');
	}
    
	/*
		Note that the frontend setup is such that user already submits the needed cpt code combo and not 
		individuals cpt codes. This is an arbitraty choice but it is very helpful. It speeds up all needed
		checks because we do not need to check every single chosen cpt code against the patient provider. 
	*/
    public function store(CreateClaimRequest $createClaimRequest): View
	{
		
		$new_progress_note = $createClaimRequest->new_progress_note;

		$newest_claim_id = (int)Claim::latest()->first()->id + 1;

		$progress_note = ProgressNote::create([
			'progress_note' => $new_progress_note,
			'claim_id' => $newest_claim_id,
		]);
		
		$provider_id = $createClaimRequest->provider_id;
		$patient_id = $createClaimRequest->patient_id;
		$cpt_code_combo_id = $createClaimRequest->cpt_code_combo_id;
		$progress_note_id = (int)ProgressNote::latest()->first()->id;
 		$status_id = 1;
		$date_of_service_time = strtotime($createClaimRequest->date_of_service);
		$date_of_service_dt = date('Y-m-d',$date_of_service_time);
		
		$newest_claim = Claim::create([
			'provider_id' => $provider_id,
			'patient_id' => $patient_id,
			'cpt_code_combo_id' => $cpt_code_combo_id,
			'progress_note_id' => $progress_note_id,
			'status_id' => $status_id,
			'date_of_service' => $date_of_service_dt,
		]);
		
		$user_id = Auth::id();
		$appUser = ApplicationUser::where('user_id',$user_id)->get();

		$this->dispatch(new ClaimWasCreated($newest_claim,$appUser));

		return redirect('employee/dashboard/claims')->with('status', 'New claim saved!');

	}

	/*
		claims which have already been approved by the FHQC billers (with claim_status = 5)
		would not be editable in the frontend
	*/
	public function edit(int $claim_id): View
	{
		$claims = Claim::all();

        if ($claims->findOrFail($claim_id) instanceof ModelNotFoundException) 
        {
            throw new ClaimNotFoundException();
        }
		
		$claim = Claim::find($claim_id);

		$progress_note = ProgressNote::where('claim_id',$claim_id)->get();

		/* Through Eloquent relationships, we get all claims related data in the view */ 

		return view('claims.edit',['claim' => $claim,'progress_note' => $progress_note]);

	}

	/*
		Note that the frontend setup is such that user already submits the needed cpt code combo and not 
		individuals cpt codes. This is an arbitraty choice but it is very helpful. It speeds up all needed
		checks because we do not need to check every single chosen cpt code against the patient provider. 
	*/
    public function update(UpdateClaimRequest $updateClaimRequest): View
	{
		$progress_note_id = $updateClaimRequest->progress_note_id;
		$progress_note_updated_content = $updateClaimRequest->progress_note_updated_content;

		$progress_note_model = ProgressNote::where('id',$progress_note_id)->get();
		$progress_note_model->progress_note = $progress_note_updated_content; 
		$progress_note_model->save();
		
		$claim_id = $updateClaimRequest->claim_id;
		$provider_id = $updateClaimRequest->provider_id;
		$patient_id = $updateClaimRequest->patient_id;
		$cpt_code_combo_id = $updateClaimRequest->cpt_code_combo_id;
		$status_id = $updateClaimRequest->status_id;
		$date_of_service_time = strtotime($updateClaimRequest->date_of_service);
		$date_of_service_dt = date('Y-m-d',$date_of_service_time);

		$claim = Claim::where('id',$claim_id)->get();

		if ($claim->status_id != 5 && $status_id = 5) {
		
			$amount = PaycodeSheet::where('$cpt_code_combo_id',$cpt_code_combo_id)->where('provider_id',$provider_id)->value('rate');

			$payment = Payment::create(['claim_id' => $claim_id,'payment_type_id' => 1, 'amount' => $amount]);
		
		}	

		$claim->provider_id = $provider_id; 
		$claim->patient_id = $patient_id;
		$claim->cpt_code_combo_id = $cpt_code_combo_id;		
		$claim->status_id = $status_id;
		$claim->date_of_service = $date_of_service_dt;

		$claim->save();
		
		$last_updated_claim = Claim::latest('updated_at')->first();

		$user_id = Auth::id();
		$appUser = ApplicationUser::where('user_id',$user_id)->get();

		$this->dispatch(new ClaimWasUpdated($last_updated_claim,$appUser));

		return redirect('employee/dashboard/claims')->with('status', 'Claim updated!');

	}

	public function delete(int $claim_id): View
	{
		$claims = Claim::all();

        if ($claims->findOrFail($claim_id) instanceof ModelNotFoundException) 
        {
            throw new ClaimNotFoundException();
        }

		$progress_note = ProgressNote::where('claim_id',$claim_id)->get();
		$progress_note->delete();

		$claim = Claim::find($claim_id);
		$claim->delete();

		$user_id = Auth::id();
		$appUser = ApplicationUser::where('user_id',$user_id)->get();

		$this->dispatch(new ClaimWasDeleted($claim_id,$appUser));
		
		return redirect('employee/dashboard/claims')->with('status', 'Claim deleted!');
	}

    public function byProvider(string $npi_number): View
	{
		$claims = Claim::filterByProvider(npi_number:$npi_number)->orderBy('created_at','asc')->paginate(10);

		/*
		   note : We check for existence in the view. Through Eloquent relationships, we get all claims
		   related data in the view. 
		*/
		return view('claims.filtered_by_provider',['claims' => $claims, 'npi_number' => $npi_number]);

	}

    public function byStatus(string $type): View
	{
       $claims = Claim::filterByStatus(type:$type)->orderBy('created_at','asc')->paginate(10);

	    /*
		   note : We check for existence in the view. Through Eloquent relationships, we get all claims
		   related data in the view 
	   */
	   return view('claims.filtered_by_claimStatus_type',['claims' => $claims, 'type' => $type]);
	   
	}

    public function between(string|null $from = null,string|null $to = null): View
	{
		$claims = Claim::submittedWithinDates(from:$from,to:$to)->orderBy('created_at','asc')->paginate(10);
	
	    /*
		   note : We check for existence in the view. Through Eloquent relationships, we get all claims
		   related data in the view 
	    */
		return view('claims.filtered_by_date',['claims' => $claims, 'from' => $from, 'to' => $to]);
	}

    public function byPatient(string $ssn): View
	{
		$claims = Claim::filterByPatient(ssn:$ssn)->orderBy('created_at','asc')->paginate(10);

	    /*
		   note : We check for existence in the view. Through Eloquent relationships, we get all claims
		   related data in the view 
	    */
		return view('claims.filtered_by_patient',['claims' => $claims, 'ssn' => $ssn]);
	}

}