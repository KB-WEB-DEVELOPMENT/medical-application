<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cpt_codes', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->enum('procedure_code_category', ['AAA','AMP','APPY','AVSD','BILI','BRST','CARD',
                'CBGB','CBGC','CEA','CHOL','COLO','CRAN','CSEC','FUSN','FX','GAST','HER',
                'HPRO','HTP','HYST','KPRO','KTP','LAM','LTP','NECK','OVRY','PACE','PRST',
                'PVBY','REC','SB','SPLE','THOR','THYR','VHYS','VSHN','XLAP'                     
            ]); 
            $table->char('cpt_code',5)->unique(); 
            $table->text('description');     
            $table->timestamps();
            $table->index(['procedure_code_category','cpt_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('cpt_codes');
    }
};
