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
        /*
            See remark in database\migrations\Practice.php file.
            For now, we are not establishing a relationship between the Practice model and the Provider model

        */
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            // https://en.wikipedia.org/wiki/National_Provider_Identifier 
            // https://en.wikipedia.org/wiki/Luhn_algorithm
            $table->char('npi_number',10)->unique();
            $table->timestamps();
            $table->index(['npi_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('providers');
    }
};
