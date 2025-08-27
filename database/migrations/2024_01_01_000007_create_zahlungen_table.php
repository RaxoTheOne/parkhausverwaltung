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
        Schema::create('zahlungen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->enum('zahlungsart', ['bar', 'kreditkarte']);
            $table->decimal('betrag', 8, 2);
            $table->decimal('rueckgeld', 8, 2)->default(0.00);
            $table->string('kreditkarten_nummer')->nullable();
            $table->timestamp('zahlungs_zeit');
            $table->enum('status', ['erfolgreich', 'fehlgeschlagen', 'storniert'])->default('erfolgreich');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zahlungen');
    }
};
