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
            $table->string('ethnicity');
            $table->string('religion');
            $table->string('civil_status');
            $table->boolean('is_temporary_resident');
            $table->boolean('is_pwd');
            $table->boolean('is_voter');
            $table->string('is_employed');
            $table->string('valid_id');
            $table->string('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident', function (Blueprint $table) {
            $table->dropColumn('ethnicity');
            $table->dropColumn('religion');
            $table->dropColumn('civil_status');
            $table->dropColumn('is_temporary_resident');
            $table->dropColumn('is_pwd');
            $table->dropColumn('is_voter');
            $table->dropColumn('is_employed');
            $table->dropColumn('valid_id');
            $table->dropColumn('is_active');
        });
    }
};
