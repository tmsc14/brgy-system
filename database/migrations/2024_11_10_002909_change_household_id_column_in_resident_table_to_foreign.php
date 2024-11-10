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
        Schema::table('resident', function (Blueprint $table)
        {
            $table->unsignedBigInteger('household_id')->nullable()->change();

            $table->foreign('household_id')
                ->references('id')
                ->on('household')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident', function (Blueprint $table)
        {
            $table->dropForeign(['household_id']);
            $table->unsignedInteger('household_id')->nullable()->change();
        });
    }
};
