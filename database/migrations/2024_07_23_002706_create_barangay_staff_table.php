<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayStaffTable extends Migration
{
    public function up()
    {
        Schema::create('barangay_staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('contact_no');
            $table->string('position');
            $table->unsignedBigInteger('barangay_id');
            $table->string('password');
            $table->string('valid_id');
            $table->timestamps();
        
            $table->foreign('barangay_id')->references('id')->on('barangays');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('barangay_staff');
    }
}
