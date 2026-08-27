<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->text('rencana_aksi')
                ->nullable()
                ->after('status_pencapaian');

            $table->text('hambatan')
                ->nullable()
                ->after('rencana_aksi');

            $table->text('evaluasi')
                ->nullable()
                ->after('hambatan');
        });
    }

    public function down(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->dropColumn([
                'rencana_aksi',
                'hambatan',
                'evaluasi',
            ]);
        });
    }
};