<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->dropForeign(['user_id']); // Drop the existing foreign key constraint
            $table->unsignedBigInteger('barangay_id')->nullable(); // Reference to the Barangay
            $table->string('role_type'); // e.g., 'barangay_captain', 'barangay_official', etc.
            $table->boolean('active')->default(true); // Indicates if this is the current active role
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('barangay_captains')->onDelete('cascade');
            $table->foreign('barangay_id')->references('id')->on('barangays')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
