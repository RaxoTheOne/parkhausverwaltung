<?php

namespace App\Services;

use App\Models\Parkhaus;
use App\Models\Parkplatz;
use App\Models\Fahrzeug;
use App\Models\Ticket;
use App\Models\EinAusfahrt;
use App\Models\Zahlung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParkhausService
{
    /**
     * Erstelle ein neues Parkhaus mit allen Parkplätzen
     */
    public function createParkhaus(array $data): Parkhaus
    {
        return DB::transaction(function () use ($data) {
            $parkhaus = Parkhaus::create($data);

            // Erstelle alle Parkplätze für das Parkhaus
            for ($ebene = 1; $ebene <= $parkhaus->anzahl_ebenen; $ebene++) {
                for ($platz = 1; $platz <= $parkhaus->parkplaetze_pro_ebene; $platz++) {
                    Parkplatz::create([
                        'parkhaus_id' => $parkhaus->id,
                        'ebene' => $ebene,
                        'parkplatz_nummer' => $platz,
                        'status' => 'frei'
                    ]);
                }
            }

            return $parkhaus;
        });
    }

    /**
     * Simuliere Einfahrt eines Fahrzeugs
     */
    public function einfahrt(string $kennzeichen, int $parkhausId, string $bildPfad = null): array
    {
        return DB::transaction(function () use ($kennzeichen, $parkhausId, $bildPfad) {
            // Finde oder erstelle Fahrzeug
            $fahrzeug = Fahrzeug::firstOrCreate(['kennzeichen' => $kennzeichen]);

            // Finde freien Parkplatz
            $freierPlatz = Parkplatz::where('parkhaus_id', $parkhausId)
                ->where('status', 'frei')
                ->first();

            if (!$freierPlatz) {
                throw new \Exception('Kein freier Parkplatz verfügbar');
            }

            // Markiere Parkplatz als besetzt
            $freierPlatz->update(['status' => 'besetzt']);

            // Erstelle Ticket
            $ticket = Ticket::create([
                'fahrzeug_id' => $fahrzeug->id,
                'parkhaus_id' => $parkhausId,
                'ticket_typ' => 'stunden',
                'einfahrts_zeit' => now(),
                'status' => 'aktiv'
            ]);

            // Erstelle Einfahrtsprotokoll
            $einAusfahrt = EinAusfahrt::create([
                'parkhaus_id' => $parkhausId,
                'fahrzeug_id' => $fahrzeug->id,
                'richtung' => 'einfahrt',
                'zeitpunkt' => now(),
                'kennzeichen_bild_pfad' => $bildPfad,
                'schranke_geoeffnet' => true
            ]);

            return [
                'ticket_id' => $ticket->id,
                'parkplatz' => $freierPlatz,
                'einAusfahrt' => $einAusfahrt
            ];
        });
    }

    /**
     * Simuliere Ausfahrt eines Fahrzeugs
     */
    public function ausfahrt(string $kennzeichen, int $parkhausId, string $bildPfad = null): array
    {
        return DB::transaction(function () use ($kennzeichen, $parkhausId, $bildPfad) {
            $fahrzeug = Fahrzeug::where('kennzeichen', $kennzeichen)->first();

            if (!$fahrzeug) {
                throw new \Exception('Fahrzeug nicht gefunden');
            }

            // Finde aktives Ticket
            $ticket = Ticket::where('fahrzeug_id', $fahrzeug->id)
                ->where('parkhaus_id', $parkhausId)
                ->where('status', 'aktiv')
                ->first();

            if (!$ticket) {
                throw new \Exception('Kein aktives Ticket gefunden');
            }

            // Prüfe ob bezahlt wurde oder Dauerticket vorhanden
            if ($ticket->isDauerticket()) {
                if ($ticket->gueltig_bis && $ticket->gueltig_bis->isPast()) {
                    throw new \Exception('Dauerticket ist abgelaufen');
                }
            } else {
                // Prüfe ob Stundenticket bezahlt wurde
                $zahlung = Zahlung::where('ticket_id', $ticket->id)
                    ->where('status', 'erfolgreich')
                    ->first();

                if (!$zahlung) {
                    throw new \Exception('Bitte erst am Kassenautomaten zahlen');
                }
            }

            // Markiere Parkplatz als frei
            $parkplatz = Parkplatz::where('parkhaus_id', $parkhausId)
                ->where('status', 'besetzt')
                ->first();

            if ($parkplatz) {
                $parkplatz->update(['status' => 'frei']);
            }

            // Schließe Ticket ab
            $ticket->update([
                'ausfahrts_zeit' => now(),
                'status' => 'abgeschlossen'
            ]);

            // Erstelle Ausfahrtsprotokoll
            $einAusfahrt = EinAusfahrt::create([
                'parkhaus_id' => $parkhausId,
                'fahrzeug_id' => $fahrzeug->id,
                'richtung' => 'ausfahrt',
                'zeitpunkt' => now(),
                'kennzeichen_bild_pfad' => $bildPfad,
                'schranke_geoeffnet' => true
            ]);

            return [
                'ticket' => $ticket,
                'parkplatz' => $parkplatz,
                'einAusfahrt' => $einAusfahrt
            ];
        });
    }

    /**
     * Berechne Parkgebühren für ein Ticket
     */
    public function berechneGebuehren(int $ticketId): float
    {
        $ticket = Ticket::findOrFail($ticketId);
        $parkhaus = $ticket->parkhaus;

        if ($ticket->isDauerticket()) {
            return 0.00; // Dauertickets sind kostenlos
        }

        $einfahrtsZeit = $ticket->einfahrts_zeit;
        $ausfahrtsZeit = $ticket->ausfahrts_zeit ?? now();

        $stunden = $einfahrtsZeit->diffInHours($ausfahrtsZeit, false);
        if ($stunden < 1) $stunden = 1; // Mindestens 1 Stunde

        return $stunden * $parkhaus->preis_pro_stunde;
    }

    /**
     * Verarbeite Zahlung
     */
    public function verarbeiteZahlung(int $ticketId, string $zahlungsart, float $gezahlterBetrag, string $kreditkartenNummer = null): Zahlung
    {
        $ticket = Ticket::findOrFail($ticketId);
        $betrag = $this->berechneGebuehren($ticketId);

        $rueckgeld = 0.00;
        if ($zahlungsart === 'bar' && $gezahlterBetrag > $betrag) {
            $rueckgeld = $gezahlterBetrag - $betrag;
        }

        $zahlung = Zahlung::create([
            'ticket_id' => $ticketId,
            'zahlungsart' => $zahlungsart,
            'betrag' => $betrag,
            'rueckgeld' => $rueckgeld,
            'kreditkarten_nummer' => $kreditkartenNummer,
            'zahlungs_zeit' => now(),
            'status' => 'erfolgreich'
        ]);

        // Aktualisiere Ticket mit gezahltem Betrag
        $ticket->update(['gezahlter_betrag' => $betrag]);

        return $zahlung;
    }

    /**
     * Erstelle Dauerticket
     */
    public function createDauerticket(string $kennzeichen, int $parkhausId, Carbon $gueltigBis): Ticket
    {
        $fahrzeug = Fahrzeug::firstOrCreate(['kennzeichen' => $kennzeichen]);

        return Ticket::create([
            'fahrzeug_id' => $fahrzeug->id,
            'parkhaus_id' => $parkhausId,
            'ticket_typ' => 'dauer',
            'status' => 'aktiv',
            'gueltig_bis' => $gueltigBis
        ]);
    }
}
