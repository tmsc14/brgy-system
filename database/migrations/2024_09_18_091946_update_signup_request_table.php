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
        Schema::table('signup_requests', function (Blueprint $table) {
            $table->dropColumn('bric_no');
            
            $table->string('house_number_building_name')->nullable();
            $table->string('street_purok_sitio')->nullable();
            $table->boolean('is_renter')->nullable()->default(false);
            $table->boolean('is_employed')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signup_requests', function (Blueprint $table) {
            $table->dropColumn('house_number_building_name');
            $table->dropColumn('street_purok_sitio');
            $table->dropColumn('is_renter');
            $table->dropColumn('is_employed');

            $table->string('bric_no');
        });
    }
};
