<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g. "Tuition Fee", "Exam Fee", "Development Levy"
            $table->decimal('amount', 12, 2);
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete(); // null = applies to all classes
            $table->foreignId('term_id')->nullable()->constrained()->nullOnDelete(); // null = applies to all terms
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index(['school_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};