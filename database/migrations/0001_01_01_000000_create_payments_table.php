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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('claim_id');
            $table->enum('payment_type_id',[1,2]);
            $table->decimal('amount',total:8,places:2);
            $table->foreign('claim_id')->references('id')->on('claims')->onDelete('cascade');
            $table->unique(['claim_id','payment_type_id']);
            $table->timestamps();
            $table->index(['claim_id','payment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('payments');
    }
};
