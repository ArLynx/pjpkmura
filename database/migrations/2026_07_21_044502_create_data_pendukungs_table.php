<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pendukungs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('realisasi_id')->constrained('realisasis')->cascadeOnDelete();

            $table->string('judul');

            $table->string('file');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pendukungs');
    }
};
