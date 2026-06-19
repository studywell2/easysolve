<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;

class SendResetLink extends Command
{
    protected $signature = 'password:send-link {email : The user email to send reset link to}';

    protected $description = 'Send a password reset link email to a user (for testing)';

    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");

            return self::FAILURE;
        }

        $this->info("Sending reset link to: {$email}");

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->info('Reset link sent successfully! Check the inbox (and spam folder).');

            return self::SUCCESS;
        }

        $this->error('Failed to send reset link: '.__($status));

        return self::FAILURE;
    }
}
