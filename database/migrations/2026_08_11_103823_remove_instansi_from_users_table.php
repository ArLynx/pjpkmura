<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'instansi')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('instansi');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'instansi')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('instansi')->nullable()->after('instansi_id');
            });
        }
    }
};