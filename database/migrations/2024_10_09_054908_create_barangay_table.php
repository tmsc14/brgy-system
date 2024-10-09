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
        Schema::create('barangay', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->primary('id');

            $table->string('name');
            $table->string('display_name');
            $table->string('description');  
            $table->string('email');
            $table->string('contact_number');
            $table->integer('region_code');
            $table->integer('province_code');
            $table->integer('city_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay');
    }
};
