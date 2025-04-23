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
        Schema::create('claim_status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->enum('code', ['PENDING_REVIEW',
                                 'REVIEWER_APPROVED',
                                 'CORRECTION_NEEDED',
                                 'BILLER_CORRECTION_NEEDED',
                                 'BILLER_APPROVED'                                
                                ])->unique();
            $table->index(['name','slug','code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('claim_status');
    }
};