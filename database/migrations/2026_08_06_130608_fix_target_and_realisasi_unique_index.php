<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | TARGETS
        |--------------------------------------------------------------------------
        */

        // Hapus foreign key indikator_id
        DB::statement('ALTER TABLE targets DROP FOREIGN KEY targets_indikator_id_foreign');

        // Hapus unique lama
        DB::statement('ALTER TABLE targets DROP INDEX targets_indikator_id_tahun_unique');

        // Buat index biasa untuk foreign key
        DB::statement('ALTER TABLE targets ADD INDEX targets_indikator_id_index (indikator_id)');

        // Buat unique baru
        DB::statement('ALTER TABLE targets ADD UNIQUE targets_indikator_id_tahun_unique (indikator_id, tahun_id)');

        // Pasang lagi foreign key
        DB::statement('ALTER TABLE targets
            ADD CONSTRAINT targets_indikator_id_foreign
            FOREIGN KEY (indikator_id)
            REFERENCES indikators(id)
            ON DELETE CASCADE');



        /*
        |--------------------------------------------------------------------------
        | REALISASIS
        |--------------------------------------------------------------------------
        */

        DB::statement('ALTER TABLE realisasis DROP FOREIGN KEY realisasis_indikator_id_foreign');

        DB::statement('ALTER TABLE realisasis DROP INDEX realisasis_indikator_id_tahun_unique');

        DB::statement('ALTER TABLE realisasis ADD INDEX realisasis_indikator_id_index (indikator_id)');

        DB::statement('ALTER TABLE realisasis ADD UNIQUE realisasis_indikator_id_tahun_unique (indikator_id, tahun_id)');

        DB::statement('ALTER TABLE realisasis
            ADD CONSTRAINT realisasis_indikator_id_foreign
            FOREIGN KEY (indikator_id)
            REFERENCES indikators(id)
            ON DELETE CASCADE');
    }

    public function down(): void
    {
        //
    }
};