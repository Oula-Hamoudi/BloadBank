<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_request_user', function (Blueprint $table) {
            $table->id();
            $table-> unsignedBigInteger('blood_request_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status')->nullable();
            $table->foreign('blood_request_id')->references('id')->on('blood_requests');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blood_request_user');
    }
};
