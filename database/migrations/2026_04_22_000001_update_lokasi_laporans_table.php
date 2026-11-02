<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->renameColumn('lokasi', 'kecamatan');
        });

        Schema::table('laporans', function (Blueprint $table) {
            $table->string('desa')->nullable()->after('kecamatan');
            $table->text('detail_alamat')->nullable()->after('desa');
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['desa', 'detail_alamat']);
        });

        Schema::table('laporans', function (Blueprint $table) {
            $table->renameColumn('kecamatan', 'lokasi');
        });
    }
};
