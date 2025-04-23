<?php

namespace Domain\Submission\App\Http\Requests;

use Claim\Submission\Domain\Rules\ProviderCptCodesComboExists;
use Claim\Submission\Domain\Rules\DateOfServiceIsValid;
use Illuminate\Foundation\Http\FormRequest;

class CreateClaimRequest extends FormRequest
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
            'provider_id' => 'required|integer|min:1|exists:providers,id',
            'patient_id' => ['required|integer|min:1|exists:patients,id',new PatientIsValidated()],
            'cpt_code_combo_id' => ['required|integer|min:1|exists:paycode_sheets,cpt_code_combo_id',new ProviderCptCodesComboExists()],
            'new_progress_note' => 'required|string|min:3|max:255',
            'date_of_service' => ['required|string',new DateOfServiceIsValid()],
        ];
    }
}