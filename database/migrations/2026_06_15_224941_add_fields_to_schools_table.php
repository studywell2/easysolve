<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'short_name')) {
                $table->string('short_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('schools', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('schools', 'motto')) {
                $table->string('motto')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['short_name', 'address', 'motto']);
        });
    }
};
