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
        note:   This table is in the book but is not actually used in the application. 
                In an ideal case, any practice would be able to register with one or more providers.
                This presupposes that practices would be OK with CPT combo rates in dollars set by
                each of these providers, as specified in the paycode_sheets table.
                I do not think that the 'one to one' relationship between a 'provider' and a
                'practice' that the author establishes on page 226 of the book is as simple as
                that and correct.
        */
        Schema::create('practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('street_address');    
            $table->enum('state');
            $table->unique(['name','street_address','state']);
            $table->timestamps();
            $table->index(['name','street_address','state']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('practices');
    }
};

