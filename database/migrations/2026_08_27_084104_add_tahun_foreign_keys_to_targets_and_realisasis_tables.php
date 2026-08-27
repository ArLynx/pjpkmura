<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->foreign('tahun_id')
                ->references('id')
                ->on('tahuns')
                ->onDelete('cascade');
        });

        Schema::table('realisasis', function (Blueprint $table) {
            $table->foreign('tahun_id')
                ->references('id')
                ->on('tahuns')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->dropForeign(['tahun_id']);
        });

        Schema::table('realisasis', function (Blueprint $table) {
            $table->dropForeign(['tahun_id']);
        });
    }
};