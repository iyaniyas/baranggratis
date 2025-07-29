<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGambarAndAlamatPengambilanToBarangsTable extends Migration
{
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            // hanya tambahkan kalau belum ada
            if (! Schema::hasColumn('barangs', 'gambar')) {
                $table->string('gambar')->nullable()->after('status_token');
            }
            if (! Schema::hasColumn('barangs', 'alamat_pengambilan')) {
                $table->string('alamat_pengambilan')->nullable()->after('gambar');
            }
        });
    }

    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'alamat_pengambilan')) {
                $table->dropColumn('alamat_pengambilan');
            }
            if (Schema::hasColumn('barangs', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
    }
}

