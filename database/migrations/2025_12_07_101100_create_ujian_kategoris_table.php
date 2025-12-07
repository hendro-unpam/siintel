<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create ujian_kategoris table
        Schema::create('ujian_kategoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained()->onDelete('cascade');
            $table->string('nama_kategori', 50); // UTS, UAS, UH, Tugas, Kuis, dll
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // Add kategori_id to ujians table
        Schema::table('ujians', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('sekolah_id')->constrained('ujian_kategoris')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ujians', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::dropIfExists('ujian_kategoris');
    }
};
