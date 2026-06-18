<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->text('terms_and_conditions')->nullable()->after('motto');
            $table->timestamp('terms_updated_at')->nullable()->after('terms_and_conditions');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['terms_and_conditions', 'terms_updated_at']);
        });
    }
};