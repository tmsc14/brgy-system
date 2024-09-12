<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('signup_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type');
            $table->unsignedBigInteger('barangay_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('contact_no');
            $table->string('valid_id');
            $table->string('password');
            $table->string('position')->nullable();
            $table->string('house_number_building_name')->nullable();
            $table->string('street_purok_sitio')->nullable();
            $table->boolean('is_renter')->default(false)->nullable();
            $table->boolean('is_employed')->default(false)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
    
            $table->foreign('barangay_id')->references('id')->on('barangays');
        });
    }

    public function down()
    {
        Schema::dropIfExists('signup_requests');
    }
}

