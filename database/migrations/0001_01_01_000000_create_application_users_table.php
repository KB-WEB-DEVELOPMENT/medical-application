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
        Schema::create('application_users', function (Blueprint $table) {
            $table->bigIncrements('application_user_id');
            $table->integer('user_id')->unique();
            $table->enum('role_id',[1,2,3,4]);
            $table->boolean('active')->default(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
            $table->index(['application_user_id','user_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('application_users');
    }
};