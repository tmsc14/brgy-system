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
        // Create features table
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('category')->nullable();
            $table->timestamps();
        });
    
        // Create barangay_feature_settings table
        Schema::create('barangay_feature_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();
    
            $table->foreign('barangay_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
        });
    
        // Create feature_permissions table with polymorphic fields
        Schema::create('feature_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_id');
            $table->morphs('permissible'); // Polymorphic relation for different user roles
            $table->enum('role', ['staff', 'official']); // Role-specific permissions
            $table->boolean('can_view')->default(false); // View permission
            $table->boolean('can_edit')->default(false); // Edit permission
            $table->timestamps();

            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feature_permissions', function (Blueprint $table) {
            $table->dropForeign(['feature_id']);
        });
        Schema::dropIfExists('feature_permissions');
    
        Schema::table('barangay_feature_settings', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropForeign(['feature_id']);
        });
        Schema::dropIfExists('barangay_feature_settings');
    
        Schema::dropIfExists('features');
    }
};
