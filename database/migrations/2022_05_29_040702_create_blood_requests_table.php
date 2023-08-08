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
        Schema::create('blood_requests', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('request_no');
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->text('patient_name');
            $table->string('gender');
            $table->string('blood_group');
            $table->unsignedBigInteger('blood_unit');
            $table->text('hospital_name');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('postOffice')->nullable();
            $table->string('postCode')->nullable();
            $table->date('require_date');
            $table->text('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->text('additional')->nullable();
            $table->text('reason');
            $table->text('official_report');
            $table->text('reject_reason')->nullable();
            $table->text('not_donated_reason')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->date('completed_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('donor_id')->references('id')->on('users');

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blood_requests');
    }
};
