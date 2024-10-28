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
        Schema::dropIfExists('feature_permissions');
    
        Schema::dropIfExists('barangay_feature_settings');
    
        Schema::dropIfExists('features');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
