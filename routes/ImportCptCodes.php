<?php

namespace Import\SingleClass;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Config;

use Claim\Submission\Domain\Models\CptCode;

use Illuminate\Console\Command;

// in terminal, type: php artisan import:CPTCodes2025 
class ImportCptCodes extends Command
{
    protected $signature = 'import:CPTCodes2025';
    protected $description = 'Import CPT codes (2025) from file config\cptCodes2025.php into the cpt_codes table if necessary';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        if (DB::table('cpt_codes')->exists()) {
            $this->error('There is no need to import the CPT codes in the cpt_codes table. The CPT codes have already been imported in the table.');
            return 1;
        }

        $allCptCodesArray = [];

        $allCptCodesArray = Config::get('app.cptCodes2025');

        $this->info('Starting to import cpt codes from the config array file');

        foreach ($allCptCodesArray as $singleCptCodeArray) {
                
            $this->persistInDB($singleCptCodeArray['procedure_code_category'],
                    $singleCptCodeArray['cpt_code'],
                    $singleCptCodeArray['description']);
        }

        $this->info('All cpt codes have successfully been imported from the config array file');

        return 0;
    }

    public function persistInDB(string $procedure_code_category,string $cpt_code, string $description): bool
    {
            $newModel = new CptCode;

            $newModel->procedure_code_category = $procedure_code_category;

            $newModel->cpt_code = $cpt_code;

            $newModel->description = $description;

            $newModel->save();
    }
}    