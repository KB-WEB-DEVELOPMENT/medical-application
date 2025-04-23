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
        Schema::create('cpt_codes_combos_lookup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cpt_code_id');
            $table->unsignedBigInteger('cpt_codes_combo_id');
            $table->timestamps();
            $table->foreign('cpt_code_id')->references('id')->on('cpt_codes')->onDelete('cascade');
            $table->foreign('cpt_codes_combo_id')->references('id')->on('cpt_codes_combos')->onDelete('cascade');
            $table->index(['cpt_code_id','cpt_codes_combo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('cpt_codes_combos_lookup');
    }
};