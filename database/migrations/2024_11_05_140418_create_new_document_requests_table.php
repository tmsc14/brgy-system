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
        Schema::create('document_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id');
            $table->id();
            $table->string('document_owner_name');
            $table->string('document_type');
            $table->text('document_data_json');
            $table->text('document_file_urls_csv');
            $table->string('status');
            $table->timestamps();

            $table->foreign('barangay_id')->references('id')->on('barangay')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
