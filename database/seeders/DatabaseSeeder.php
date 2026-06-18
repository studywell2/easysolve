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
        User::create([
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'email'      => 'admin@easysolve.com',
            'password'   => Hash::make('password'),
            'role'       => 'super_admin',
        ]);

        User::factory()->create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@example.com',
        ]);
    }
}
