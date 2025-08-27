<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parkplaetze', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkhaus_id')->constrained('parkhaeuser')->onDelete('cascade');
            $table->integer('ebene');
            $table->integer('parkplatz_nummer');
            $table->enum('status', ['frei', 'besetzt', 'reserviert', 'gesperrt'])->default('frei');
            $table->timestamps();

            $table->unique(['parkhaus_id', 'ebene', 'parkplatz_nummer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkplaetze');
    }
};
