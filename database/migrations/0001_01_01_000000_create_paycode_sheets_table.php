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
        Schema::create('paycode_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cpt_codes_combo_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('fqhc_center_id');
            $table->decimal('rate',8,2);
            $table->decimal('rate_multiplicator',total:1,places:2); 
            $table->timestamps();
            $table->unique(['cpt_codes_combo_id','provider_id','fqhc_center_id']);
            $table->foreign('cpt_codes_combo_id')->references('id')->on('cpt_codes_combos')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('fqhc_center_id')->references('id')->on('fqhc_centers')->onDelete('cascade');
            $table->index(['cpt_codes_combo_id','provider_id','fqhc_center_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('paycode_sheets');
    }
};
