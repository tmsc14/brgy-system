<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('signup_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id');
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('user_type');
            $table->string('position')->nullable();
            $table->string('valid_id');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signup_requests');
    }
}

