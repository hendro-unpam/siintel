<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get first sekolah id as default
        $defaultSekolahId = DB::table('sekolahs')->first()?->id ?? 1;

        // Add sekolah_id to users table
        if (!Schema::hasColumn('users', 'sekolah_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
            });
            
            // Set default for existing records
            DB::table('users')->whereNull('sekolah_id')->update(['sekolah_id' => $defaultSekolahId]);
            
            // Add foreign key
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('sekolah_id')->references('id')->on('sekolahs')->nullOnDelete();
            });
        }

        // Add sekolah_id to gurus table
        if (!Schema::hasColumn('gurus', 'sekolah_id')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
            });
            
            DB::table('gurus')->whereNull('sekolah_id')->update(['sekolah_id' => $defaultSekolahId]);
            
            Schema::table('gurus', function (Blueprint $table) {
                $table->foreign('sekolah_id')->references('id')->on('sekolahs')->nullOnDelete();
            });
        }

        // Add sekolah_id to siswas table
        if (!Schema::hasColumn('siswas', 'sekolah_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
            });
            
            DB::table('siswas')->whereNull('sekolah_id')->update(['sekolah_id' => $defaultSekolahId]);
            
            Schema::table('siswas', function (Blueprint $table) {
                $table->foreign('sekolah_id')->references('id')->on('sekolahs')->nullOnDelete();
            });
        }

        // Add sekolah_id to kelas table
        if (!Schema::hasColumn('kelas', 'sekolah_id')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
            });
            
            DB::table('kelas')->whereNull('sekolah_id')->update(['sekolah_id' => $defaultSekolahId]);
            
            Schema::table('kelas', function (Blueprint $table) {
                $table->foreign('sekolah_id')->references('id')->on('sekolahs')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'sekolah_id')) {
                $table->dropForeign(['sekolah_id']);
                $table->dropColumn('sekolah_id');
            }
        });

        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'sekolah_id')) {
                $table->dropForeign(['sekolah_id']);
                $table->dropColumn('sekolah_id');
            }
        });

        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'sekolah_id')) {
                $table->dropForeign(['sekolah_id']);
                $table->dropColumn('sekolah_id');
            }
        });

        Schema::table('kelas', function (Blueprint $table) {
            if (Schema::hasColumn('kelas', 'sekolah_id')) {
                $table->dropForeign(['sekolah_id']);
                $table->dropColumn('sekolah_id');
            }
        });
    }
};
