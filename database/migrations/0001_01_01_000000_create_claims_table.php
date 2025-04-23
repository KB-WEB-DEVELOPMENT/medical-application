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
        Schema::create('claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('cpt_codes_combo_id');
            $table->unsignedBigInteger('progress_note_id');
            $table->integer('status_id');
            $table->datetime('date_of_service');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('cpt_codes_combo_id')->references('id')->on('cpt_codes_combos')->onDelete('cascade');
            $table->foreign('progress_note_id')->references('id')->on('progress_notes');
            $table->foreign('status_id')->references('id')->on('claim_status')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['provider_id','patient_id','cpt_codes_combo_id']);
            $table->index(['id','provider_id','patient_id','cpt_codes_combo_id','status_id','date_of_service']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('claims');
    }
};
