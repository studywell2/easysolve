<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small schools getting started with digital management.',
                'price_monthly' => 5000,
                'price_yearly' => 50000,
                'max_students' => 200,
                'max_staff' => 10,
                'features' => [
                    'Up to 200 students',
                    'Attendance tracking',
                    'Grade management',
                    'Fee collection',
                    'Parent portal access',
                    'Email support',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Growth',
                'slug' => 'growth',
                'description' => 'For growing schools that need advanced features and more capacity.',
                'price_monthly' => 15000,
                'price_yearly' => 150000,
                'max_students' => 1000,
                'max_staff' => 50,
                'features' => [
                    'Up to 1,000 students',
                    'Everything in Starter',
                    'Academic session management',
                    'Report cards & transcripts',
                    'Announcements & messaging',
                    'Priority support',
                    'Custom school branding',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Unlimited everything for large institutions with advanced needs.',
                'price_monthly' => 35000,
                'price_yearly' => 350000,
                'max_students' => null,
                'max_staff' => null,
                'features' => [
                    'Unlimited students & staff',
                    'Everything in Growth',
                    'Dedicated account manager',
                    'Custom integrations & API',
                    'Advanced analytics dashboard',
                    '24/7 phone & email support',
                    'Onboarding & training sessions',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
