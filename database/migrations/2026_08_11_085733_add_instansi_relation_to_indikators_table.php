<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            // Instansi utama / penanggung jawab indikator
            $table->foreignId('instansi_id')
                ->nullable()
                ->after('pilar_id')
                ->constrained('instansis')
                ->nullOnDelete();

            // Daftar instansi pendukung, ditulis manual
            $table->text('instansi_pendukung')
                ->nullable()
                ->after('instansi');
        });
    }

    public function down(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            $table->dropForeign(['instansi_id']);
            $table->dropColumn([
                'instansi_id',
                'instansi_pendukung',
            ]);
        });
    }
};