<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    protected $signature = 'password:reset {email : The user\'s email address} {--password= : New password (optional, will prompt if not provided)}';

    protected $description = 'Reset a user\'s password directly from the CLI (bypasses email)';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->option('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");

            return self::FAILURE;
        }

        $this->info("Found user: {$user->name} ({$user->email})");

        if (! $password) {
            $password = $this->secret('Enter new password');
        }

        if (! $password || strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');

            return self::FAILURE;
        }

        $user->forceFill([
            'password' => Hash::make($password),
        ])->save();

        $this->info("✅ Password reset successfully for {$user->email}");
        $this->warn('The user can now log in with the new password.');

        return self::SUCCESS;
    }
}
