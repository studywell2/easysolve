<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
        ]);

        // Super Admin — can access the platform admin panel at /admin
        // IMPORTANT: Change this password immediately after deployment!
        User::firstOrCreate(
            ['email' => 'admin@easysolve.com'],
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'password'   => Hash::make(env('SUPER_ADMIN_PASSWORD', 'Ea$ySolve@2026!Adm')),
                'role'       => 'super_admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name'         => 'Test',
                'last_name'          => 'User',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'role'               => 'owner',
            ]
        );
    }
}
