<?php

namespace Claim\Submission\Domain\Services\Contracts;

use Claim\Submission\Domain\Models\CptCodesCombo;
use Claim\Submission\Domain\Models\Provider;
use Claim\Submission\Domain\Models\Center;

use Illuminate\Database\Eloquent\Collection;

interface PaycodeSheetServiceInterface {

    public function paycodeSheetRowEntryExists(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): bool

    public function cptCodesCombo(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?CptCodesCombo

    public function comboCptCodes(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): array

    public function cptCodeBelongsToRowEntry(string $cpt_code,int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): bool

    public function provider(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?Provider

    public function center(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?Center

    public function rate(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?float

    public function rateMultiplicator(int $cpt_codes_combo_id,int $provider_id,int $fqhc_center_id): ?float

    public function byProvider(null|int $provider_id = null,null|string $npi_number = null): Collection

    public function byCenter(int $fqhc_center_id): Collection

}