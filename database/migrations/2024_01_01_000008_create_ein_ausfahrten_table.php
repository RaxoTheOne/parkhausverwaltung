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
        Schema::create('ein_ausfahrten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkhaus_id')->constrained('parkhaeuser')->onDelete('cascade');
            $table->foreignId('fahrzeug_id')->constrained('fahrzeuge')->onDelete('cascade');
            $table->enum('richtung', ['einfahrt', 'ausfahrt']);
            $table->timestamp('zeitpunkt');
            $table->string('kennzeichen_bild_pfad')->nullable();
            $table->boolean('schranke_geoeffnet')->default(false);
            $table->text('bemerkungen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ein_ausfahrten');
    }
};
