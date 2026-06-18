<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('schools', function (Blueprint $table) {
    $table->id();

    $table->string('name');
    $table->string('email')->nullable()->index();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();

    // SaaS control
    $table->enum('subscription_status', ['trial', 'active', 'expired'])
        ->default('trial');

    $table->timestamp('trial_ends_at')->nullable();

    // Important for linking owner early (optional but recommended)
    $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
