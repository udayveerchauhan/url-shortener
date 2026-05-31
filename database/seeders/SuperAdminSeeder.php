<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'superadmin@example.com';

        if (DB::table('users')->where('email', $email)->exists()) {
            return;
        }

        DB::statement(
            'INSERT INTO users (company_id, name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)',
            [
                null,
                'Super Admin',
                $email,
                Hash::make('password'),
                now(),
                now(),
            ]
        );

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->assignRole('SuperAdmin');
        }
    }
}
