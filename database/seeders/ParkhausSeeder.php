<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parkhaus;
use App\Models\Parkplatz;

class ParkhausSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Erstelle Beispieldaten für Parkhäuser
        $parkhaus1 = Parkhaus::create([
            'name' => 'Parkhaus Zentrum',
            'anzahl_ebenen' => 3,
            'parkplaetze_pro_ebene' => 50,
            'preis_pro_stunde' => 2.50
        ]);

        $parkhaus2 = Parkhaus::create([
            'name' => 'Parkhaus Bahnhof',
            'anzahl_ebenen' => 2,
            'parkplaetze_pro_ebene' => 30,
            'preis_pro_stunde' => 3.00
        ]);

        // Erstelle Parkplätze für Parkhaus 1
        for ($ebene = 1; $ebene <= $parkhaus1->anzahl_ebenen; $ebene++) {
            for ($platz = 1; $platz <= $parkhaus1->parkplaetze_pro_ebene; $platz++) {
                Parkplatz::create([
                    'parkhaus_id' => $parkhaus1->id,
                    'ebene' => $ebene,
                    'parkplatz_nummer' => $platz,
                    'status' => 'frei'
                ]);
            }
        }

        // Erstelle Parkplätze für Parkhaus 2
        for ($ebene = 1; $ebene <= $parkhaus2->anzahl_ebenen; $ebene++) {
            for ($platz = 1; $platz <= $parkhaus2->parkplaetze_pro_ebene; $platz++) {
                Parkplatz::create([
                    'parkhaus_id' => $parkhaus2->id,
                    'ebene' => $ebene,
                    'parkplatz_nummer' => $platz,
                    'status' => 'frei'
                ]);
            }
        }

        // Keine Beispielfahrzeuge oder Tickets erstellen
        // Diese werden später über die Anwendung hinzugefügt
    }
}
