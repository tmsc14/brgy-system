<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangaysTable extends Migration
{
    public function up()
    {
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_captain_id');
            $table->string('barangay_name');
            $table->string('barangay_email');
            $table->string('barangay_office_address');
            $table->string('barangay_complete_address_1');
            $table->string('barangay_complete_address_2')->nullable();
            $table->text('barangay_description');
            $table->string('barangay_contact_number');
            $table->timestamps();

            $table->foreign('barangay_captain_id')->references('id')->on('barangay_captains')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangays');
    }
}
