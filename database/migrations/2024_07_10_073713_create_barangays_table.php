<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangaysTable extends Migration
{
    public function up()
    {
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('province');
            $table->string('city_municipality');
            $table->string('barangay');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangays');
    }
}

