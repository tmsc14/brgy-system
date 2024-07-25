<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeographicDataToBarangaysTable extends Migration
{
    public function up()
    {
        Schema::table('barangays', function (Blueprint $table) {
            $table->string('region')->after('barangay_contact_number');
            $table->string('province')->after('region');
            $table->string('city')->after('province');
            $table->string('barangay')->after('city');
        });
    }

    public function down()
    {
        Schema::table('barangays', function (Blueprint $table) {
            $table->dropColumn(['region', 'province', 'city', 'barangay']);
        });
    }
}
