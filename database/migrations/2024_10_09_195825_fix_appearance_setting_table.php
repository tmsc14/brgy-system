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
        Schema::table('appearance_settings', function (Blueprint $table)
        {
            $table->unsignedBigInteger('barangay_id');

            $table->dropForeign(['barangay_captain_id']);

            $table->dropColumn('barangay_captain_id');

            $table->foreign('barangay_id')->references('id')->on('barangay')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appearance_settings', function (Blueprint $table)
        {
            $table->dropColumn('barangay_id');

            $table->unsignedBigInteger('barangay_captain_id');

            $table->foreign('barangay_captain_id')->references('id')->on('barangay_captains')->onDelete('cascade');

            $table->dropForeign('barangay_id')->references('id')->on('barangay')->onDelete('cascade');
        });
    }
};
