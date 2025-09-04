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
        Schema::table('barangs', function (Blueprint $table) {
            $table->boolean('is_request')->default(false)->after('status_token');
            $table->integer('jumlah_diminta')->nullable()->after('is_request');
            $table->timestamp('approved_at')->nullable()->after('jumlah_diminta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['is_request', 'jumlah_diminta', 'approved_at']);
        });
    }
};
