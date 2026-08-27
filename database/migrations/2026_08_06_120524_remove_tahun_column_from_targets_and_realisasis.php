<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Targets
        |--------------------------------------------------------------------------
        */

        Schema::table('targets', function (Blueprint $table) {

            if (Schema::hasColumn('targets', 'tahun')) {
                $table->dropColumn('tahun');
            }

        });

        /*
        |--------------------------------------------------------------------------
        | Realisasis
        |--------------------------------------------------------------------------
        */

        Schema::table('realisasis', function (Blueprint $table) {

            if (Schema::hasColumn('realisasis', 'tahun')) {
                $table->dropColumn('tahun');
            }

        });
    }

    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {

            if (! Schema::hasColumn('targets', 'tahun')) {
                $table->year('tahun')->nullable();
            }

        });

        Schema::table('realisasis', function (Blueprint $table) {

            if (! Schema::hasColumn('realisasis', 'tahun')) {
                $table->year('tahun')->nullable();
            }

        });
    }
};