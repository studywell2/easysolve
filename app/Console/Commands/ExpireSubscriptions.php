<?php

namespace App\Console\Commands;

use App\Models\School;
use App\Models\Subscription;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';

    protected $description = 'Expire subscriptions and trials that have passed their end date';

    public function handle(): int
    {
        $expiredSubs = $this->expireSubscriptions();
        $expiredTrials = $this->expireTrials();

        $this->info("Expired {$expiredSubs} subscription(s) and {$expiredTrials} trial(s).");

        return self::SUCCESS;
    }

    /**
     * Mark active subscriptions past their ends_at as expired,
     * and cascade the school's subscription_status to 'expired'.
     */
    private function expireSubscriptions(): int
    {
        $subs = Subscription::where('status', 'active')
            ->where('ends_at', '<', now())
            ->get();

        foreach ($subs as $sub) {
            $sub->update(['status' => 'expired']);

            // Only expire the school if it has no *other* active subscription
            $stillActive = Subscription::where('school_id', $sub->school_id)
                ->where('id', '!=', $sub->id)
                ->where('status', 'active')
                ->where('ends_at', '>', now())
                ->exists();

            if (!$stillActive) {
                School::where('id', $sub->school_id)
                    ->where('subscription_status', 'active')
                    ->update(['subscription_status' => 'expired']);
            }
        }

        return $subs->count();
    }

    /**
     * Move schools whose trial has ended from 'trial' to 'expired'.
     */
    private function expireTrials(): int
    {
        return School::where('subscription_status', 'trial')
            ->where('trial_ends_at', '<', now())
            ->update(['subscription_status' => 'expired']);
    }
}
