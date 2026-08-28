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
        | TARGETS
        |--------------------------------------------------------------------------
        */

        Schema::table('targets', function (Blueprint $table) {

            // Hapus foreign key indikator_id.
            $table->dropForeign(['indikator_id']);

            // Buat index biasa untuk foreign key.
            $table->index('indikator_id');

            // Buat unique baru berbasis tahun_id.
            $table->unique(['indikator_id', 'tahun_id']);

            // Pasang lagi foreign key.
            $table->foreign('indikator_id')
                ->references('id')
                ->on('indikators')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | REALISASIS
        |--------------------------------------------------------------------------
        */

        Schema::table('realisasis', function (Blueprint $table) {

            // Hapus foreign key indikator_id.
            $table->dropForeign(['indikator_id']);

            // Buat index biasa untuk foreign key.
            $table->index('indikator_id');

            // Buat unique baru berbasis tahun_id.
            $table->unique(['indikator_id', 'tahun_id']);

            // Pasang lagi foreign key.
            $table->foreign('indikator_id')
                ->references('id')
                ->on('indikators')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        //
    }
};
