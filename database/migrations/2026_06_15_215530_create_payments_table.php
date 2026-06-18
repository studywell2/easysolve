<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('fee_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('balance', 12, 2)->default(0);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'card', 'online', 'cheque'])->default('cash');
            $table->string('reference')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'partial'])->default('completed');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['school_id', 'status']);
            $table->index(['student_id', 'fee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};