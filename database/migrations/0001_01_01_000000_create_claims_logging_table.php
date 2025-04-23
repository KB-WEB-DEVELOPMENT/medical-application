claim_logging
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
           Application users are never deleted from the system. There is no need to cascade delete 
           the 'event_doer_user_id' field.
           We prevent an unwanted application user from logging in to the system
           by setting the application user 'active' field to false. We create an authentication
           system such that only application users with their 'active' field set to true can log in.
        */
        Schema::create('claims_logging', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_name');
            $table->unsignedBigInteger('claim_id');
            $table->unsignedBigInteger('event_doer_user_id');
            $table->foreign('event_doer_user_id')->references('application_user_id')->on('application_users');  
            $table->timestamps();
            $table->index(['event_name','claim_id','event_doer_user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('claims_logging');
    }
};
