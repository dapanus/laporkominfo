<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('id_laporan')->unique(); // ADU-XXXXXXXX or ASP-XXXXXXXX
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('jenis_laporan', ['pengaduan', 'aspirasi']);
            $table->enum('kategori', ['infrastruktur_jaringan', 'layanan_digital', 'hoaks', 'data_sistem']);
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->json('foto')->nullable();
            $table->enum('status', ['menunggu_verifikasi', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('menunggu_verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->index(['status', 'jenis_laporan']);
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
