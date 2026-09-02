<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_pimpinan')->nullable()->after('instansi_id');
            $table->string('pangkat_golongan')->nullable()->after('nama_pimpinan');
            $table->string('nip', 30)->nullable()->after('pangkat_golongan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pimpinan',
                'pangkat_golongan',
                'nip',
            ]);
        });
    }
};