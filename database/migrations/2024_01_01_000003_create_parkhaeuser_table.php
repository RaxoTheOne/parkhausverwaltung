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
        Schema::create('parkhaeuser', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('anzahl_ebenen');
            $table->integer('parkplaetze_pro_ebene');
            $table->decimal('preis_pro_stunde', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkhaeuser');
    }
};
