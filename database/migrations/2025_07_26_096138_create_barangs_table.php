<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
	    $table->unsignedBigInteger('kategori_id')->nullable();
	    $table->unsignedBigInteger('lokasi_id')->nullable();
	    $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
	    $table->foreign('lokasi_id')->references('id')->on('lokasis')->onDelete('set null');
	    $table->string('gambar')->nullable();
            $table->enum('status', ['tersedia', 'sudah diambil'])->default('tersedia');
            $table->unsignedBigInteger('user_id');
	    $table->timestamps();
	    $table->string('status_token', 64)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};

