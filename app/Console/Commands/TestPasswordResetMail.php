<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class TestPasswordResetMail extends Command
{
    protected $signature = 'mail:test-reset {email=admin@easysolve.com}';
    protected $description = 'Test sending a password reset email';

    public function handle(): int
    {
        $email = $this->argument('email');

        $this->info("Sending password reset link to: {$email}");

        try {
            $status = Password::sendResetLink(['email' => $email]);

            $this->info("Status: {$status}");

            if ($status === Password::RESET_LINK_SENT) {
                $this->info('SUCCESS: Reset link email was dispatched.');
            } else {
                $this->error("FAILED: {$status}");
            }
        } catch (\Exception $e) {
            $this->error('EXCEPTION: ' . $e->getMessage());
            $this->error('FILE: ' . $e->getFile() . ':' . $e->getLine());
        }

        $jobs = DB::table('jobs')->count();
        $this->info("Jobs in queue table: {$jobs}");

        $failedJobs = DB::table('failed_jobs')->count();
        $this->info("Failed jobs in table: {$failedJobs}");

        if ($jobs > 0) {
            $this->warn('NOTICE: There are queued jobs that have NOT been processed!');
            $this->warn('Run "php artisan queue:work" to process them, or remove ShouldQueue from the notification.');
        }

        return Command::SUCCESS;
    }
}
