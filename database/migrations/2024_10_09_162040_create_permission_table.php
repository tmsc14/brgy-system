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
        Schema::create('permission', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id');
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('feature_name');
            $table->boolean('read');
            $table->boolean('write');
            $table->boolean('delete');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
