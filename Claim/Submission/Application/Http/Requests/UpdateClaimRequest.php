<?php

namespace Domain\Submission\App\Http\Requests;

use Claim\Submission\Domain\Rules\ProviderCptCodesComboExists;
use Claim\Submission\Domain\Rules\DateOfServiceIsValid;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClaimRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; 
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
    public function rules(): array
    {
        return [
            'claim_id' => 'required|integer|min:1|exists:claims,id',
            'provider_id' => 'required|integer|min:1|exists:providers,id',
            'patient_id' => ['required|integer|min:1|exists:patients,id',new PatientExistsAndIsValidated()],
            'cpt_code_combo_id' => ['required|integer|min:1|exists:paycode_sheets,cpt_code_combo_id', new ProviderCptCodesComboExists()],
            'progress_note_id' => 'required|integer|min:1|exists:progress_notes,id',
            'progress_note_updated_content' => 'required|string|min:3|max:255',
            'status_id' => 'required|integer|min:1|exists:claim_status,id',
            'date_of_service' => ['required|string', new DateOfServiceIsValid()],
        ];
    }
}