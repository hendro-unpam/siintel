<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set default password "password" for all guru that don't have password
        $hashedPassword = Hash::make('password');
        
        DB::table('gurus')
            ->whereNull('password')
            ->orWhere('password', '')
            ->update(['password' => $hashedPassword]);
        
        // Set default password for all siswa that don't have password
        DB::table('siswas')
            ->whereNull('password')
            ->orWhere('password', '')
            ->update(['password' => $hashedPassword]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse password setting
    }
};
