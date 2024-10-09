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
        Schema::table('barangay', function (Blueprint $table) {
            $table->string('barangay_office_address');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangay', function (Blueprint $table) {
            $table->dropColumn(['barangay_office_address', 'address_line_one', 'address_line_two']);
        });
    }
};
