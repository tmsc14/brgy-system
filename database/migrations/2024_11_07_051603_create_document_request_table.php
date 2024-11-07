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
        Schema::dropIfExists('document_requests');

        Schema::create('document_request', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id');
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('requester_entity_id');
            $table->string('requester_entity_type');
            $table->string('document_type');
            $table->text('document_data_json');
            $table->text('document_file_urls_csv');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_request');
    }
};
