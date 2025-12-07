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
        // Berita Table
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('judul');
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->string('penulis')->default('Admin');
            $table->date('tanggal_post');
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        // Prestasi Table
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('judul');
            $table->enum('kategori', ['akademik', 'non_akademik']);
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });

        // Ekstrakurikuler Table
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('pembina')->nullable();
            $table->string('jadwal')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler');
        Schema::dropIfExists('prestasi');
        Schema::dropIfExists('berita');
    }
};
