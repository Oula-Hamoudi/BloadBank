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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('division');
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('postOffice')->nullable();
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('postCode')->nullable();

            $table->string('profile_image')->nullable();
            $table->string('nid_image')->nullable();

            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('profiles');
    }
};
