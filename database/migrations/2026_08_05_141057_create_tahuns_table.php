<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahuns', function (Blueprint $table) {

            $table->id();

            $table->unsignedSmallInteger('tahun')->unique();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahuns');
    }
};