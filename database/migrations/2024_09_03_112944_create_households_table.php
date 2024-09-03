<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdsTable extends Migration
{
    public function up()
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id'); // Foreign key to barangay_residents table
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('bric_no');
            $table->string('gender');
            $table->boolean('is_employee')->default(false);
            $table->timestamps();

            // Foreign key constraint to barangay_residents table
            $table->foreign('resident_id')->references('id')->on('barangay_residents')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('households');
    }
}

