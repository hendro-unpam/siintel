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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50)->unique();
            $table->string('nama', 100);
            $table->enum('jk', ['L', 'P'])->default('L');
            $table->text('alamat')->nullable();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tlp', 20)->nullable();
            $table->string('bapak', 50)->nullable();
            $table->string('k_bapak', 50)->nullable();
            $table->string('ibu', 50)->nullable();
            $table->string('k_ibu', 50)->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
