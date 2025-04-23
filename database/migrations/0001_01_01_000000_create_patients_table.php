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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('height',3,2);
            $table->int('weight');
            $table->date('date_of_birth'); 
            $table->enum('gender',['male','female']);
            $table->enum('eye_color',['brown','blue','hazel','amber','gray','green','other']);
            $table->enum('hair_color',['black','brown','blonde','red','other']);
            $table->char('ssn',11)->unique();
            $table->string('street_addess');
            $table->json('emergency_contacts')->nullable();
            $table->string('identification_card_screenshot')->nullable();
            $table->boolean('validated_id_card')->default(0);
            $table->string('driving_license_screenshot')->nullable();
            $table->boolean('validated_driving_license')->default(0);
            $table->string('medi_cal_screenshot');
            $table->boolean('validated_medi_cal')->default(0);
            $table->string('signed_contract_screenshot');
            $table->boolean('validated_signed_contract')->default(0);
            $table->index(['ssn']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('patients');
    }
};
