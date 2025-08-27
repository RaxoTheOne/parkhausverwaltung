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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fahrzeug_id')->constrained('fahrzeuge')->onDelete('cascade');
            $table->foreignId('parkhaus_id')->constrained('parkhaeuser')->onDelete('cascade');
            $table->enum('ticket_typ', ['stunden', 'dauer'])->default('stunden');
            $table->timestamp('einfahrts_zeit')->nullable();
            $table->timestamp('ausfahrts_zeit')->nullable();
            $table->decimal('gezahlter_betrag', 8, 2)->default(0.00);
            $table->enum('status', ['aktiv', 'abgeschlossen', 'storniert'])->default('aktiv');
            $table->timestamp('gueltig_bis')->nullable(); // Für Dauertickets
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
