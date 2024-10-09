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
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->string('description');  
            $table->string('email');
            $table->string('contact_number');
            $table->string('region_code');
            $table->string('province_code');
            $table->string('city_code');
            $table->string('barangay_code');
            $table->boolean('is_setup_complete')->default(false);
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
