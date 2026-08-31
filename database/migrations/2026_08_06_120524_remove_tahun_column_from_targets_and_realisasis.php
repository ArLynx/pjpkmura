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

                // MySQL menggunakan unique key [indikator_id, tahun] untuk mendukung foreign key indikator_id.
                // Tambahkan index biasa terlebih dahulu agar foreign key tetap valid saat unique key dihapus.
                $table->index('indikator_id', 'targets_indikator_id_index');

                // Lepas unique lama yang masih mereferensikan kolom tahun
                $table->dropUnique('targets_indikator_id_tahun_unique');

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

                // Tambahkan index biasa terlebih dahulu agar foreign key tetap valid saat unique key dihapus.
                $table->index('indikator_id', 'realisasis_indikator_id_index');

                // Lepas unique lama yang masih mereferensikan kolom tahun
                $table->dropUnique('realisasis_indikator_id_tahun_unique');

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
