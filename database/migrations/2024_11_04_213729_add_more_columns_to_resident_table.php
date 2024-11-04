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
        Schema::table('resident', function (Blueprint $table) {
            $table->string('is_birth_registered');
            $table->boolean('is_literate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident', function (Blueprint $table) {
            $table->dropColumn('is_birth_registered');
            $table->dropColumn('is_literate');
        });
    }
};
