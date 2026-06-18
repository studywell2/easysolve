<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite doesn't support ALTER COLUMN on enums,
        // so we modify the type constraint directly
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin','owner','admin','teacher','parent','student') NOT NULL DEFAULT 'student'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('owner','admin','teacher','parent','student') NOT NULL DEFAULT 'student'");
    }
};