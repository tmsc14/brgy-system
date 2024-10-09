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
        Schema::create('resident', function (Blueprint $table) {
            $table->unsignedInteger('barangay_id');
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('cascade');
            $table->unsignedInteger('household_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('email');
            $table->string('contact_number');
            $table->date('date_of_birth');
            $table->string('bric_number');
            $table->boolean('is_head_of_household');
            $table->boolean('relationship_to_head')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident');
    }
};
