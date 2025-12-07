<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Sekolah;

class SchoolAdminSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('password');

        // Ensure schools exist (just in case, though we know they do from previous steps)
        // We assume IDs 1, 2, 3 correspond to TK, SD, SMP as updated previously.

        // TK Admin
        User::updateOrCreate(
            ['email' => 'admin.tk@siintel.com'],
            [
                'name' => 'Admin TK',
                'password' => $password,
                'sekolah_id' => 1
            ]
        );

        // SD Admin
        User::updateOrCreate(
            ['email' => 'admin.sd@siintel.com'],
            [
                'name' => 'Admin SD',
                'password' => $password,
                'sekolah_id' => 2
            ]
        );

        // SMP Admin
        User::updateOrCreate(
            ['email' => 'admin.smp@siintel.com'],
            [
                'name' => 'Admin SMP',
                'password' => $password,
                'sekolah_id' => 3
            ]
        );
        
        $this->command->info('School Admins seeded successfully!');
    }
}
