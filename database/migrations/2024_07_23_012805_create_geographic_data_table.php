<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeographicDataTable extends Migration
{
    public function up()
    {
        Schema::create('geographic_data', function (Blueprint $table) {
            $table->id();
            $table->string('regCode');
            $table->string('regDesc');
            $table->string('provCode')->nullable();
            $table->string('provDesc')->nullable();
            $table->string('citymunCode')->nullable();
            $table->string('citymunDesc')->nullable();
            $table->string('brgyCode')->nullable();
            $table->string('brgyDesc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('geographic_data');
    }
}
