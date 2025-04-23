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
        Schema::create('progress_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('progress_note');
            $table->unsignedBigInteger('claim_id');
            $table->unique(['progress_note','claim_id']);
            $table->timestamps();
            $table->index(['id','progress_note','claim_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('progress_notes');
    }
};