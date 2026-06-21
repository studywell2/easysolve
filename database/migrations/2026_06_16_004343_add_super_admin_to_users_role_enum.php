<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL and SQLite already support 'super_admin' via the enum
        // definition in the users table migration. Only MySQL needs an explicit ALTER.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin','owner','admin','teacher','parent','student') NOT NULL DEFAULT 'student'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('owner','admin','teacher','parent','student') NOT NULL DEFAULT 'student'");
        }
    }
};