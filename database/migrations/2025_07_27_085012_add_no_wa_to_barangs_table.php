<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoWaToBarangsTable extends Migration
{
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('no_wa', 20)->nullable()->after('lokasi_id');
        });
    }

    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('no_wa');
        });
    }
}

