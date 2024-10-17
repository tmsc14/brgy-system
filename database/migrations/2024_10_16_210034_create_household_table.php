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
        Schema::create('household', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id');
            $table->id();
            $table->unsignedBigInteger('household_head_user_id');
            $table->string('street_address');
            $table->string('purok');
            $table->string('sitio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household');
    }
};
