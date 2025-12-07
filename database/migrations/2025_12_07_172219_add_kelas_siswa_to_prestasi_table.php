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
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('sekolah_id')->constrained('kelas')->nullOnDelete();
            $table->foreignId('siswa_id')->nullable()->after('kelas_id')->constrained('siswas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['siswa_id', 'kelas_id']);
        });
    }
};
