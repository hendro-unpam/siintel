<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Add new columns for foreign keys
            $table->foreignId('pekerjaan_ayah_id')->nullable()->after('k_bapak')->constrained('pekerjaans')->nullOnDelete();
            $table->foreignId('pekerjaan_ibu_id')->nullable()->after('k_ibu')->constrained('pekerjaans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['pekerjaan_ayah_id']);
            $table->dropForeign(['pekerjaan_ibu_id']);
            $table->dropColumn(['pekerjaan_ayah_id', 'pekerjaan_ibu_id']);
        });
    }
};
