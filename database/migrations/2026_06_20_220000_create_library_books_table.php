<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('isbn')->nullable();
            $table->string('category')->nullable();
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('shelf_location')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('available'); // available, lost, damaged
            $table->timestamps();

            $table->index(['school_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_books');
    }
};
