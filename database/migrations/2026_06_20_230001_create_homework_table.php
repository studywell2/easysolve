<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('term_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->decimal('max_score', 5, 2)->default(100);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();

            $table->index(['school_id', 'status']);
            $table->index(['class_id', 'due_date']);
            $table->index(['teacher_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
