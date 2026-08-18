<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('instansi_id')
                ->nullable()
                ->after('role')
                ->constrained('instansis')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Pindahkan data instansi lama ke instansi_id
        |--------------------------------------------------------------------------
        */

        DB::statement('
            UPDATE users
            SET instansi_id = (
                SELECT instansis.id
                FROM instansis
                WHERE LOWER(TRIM(instansis.nama)) = LOWER(TRIM(instansi))
                LIMIT 1
            )
            WHERE instansi IS NOT NULL
        ');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['instansi_id']);
            $table->dropColumn('instansi_id');
        });
    }
};
