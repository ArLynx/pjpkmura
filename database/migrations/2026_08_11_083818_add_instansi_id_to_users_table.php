<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::statement("
            UPDATE users
            INNER JOIN instansis
                ON LOWER(TRIM(users.instansi)) = LOWER(TRIM(instansis.nama))
            SET users.instansi_id = instansis.id
            WHERE users.instansi IS NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['instansi_id']);
            $table->dropColumn('instansi_id');
        });
    }
};