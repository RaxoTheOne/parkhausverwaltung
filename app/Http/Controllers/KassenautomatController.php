<?php

namespace App\Http\Controllers;

use App\Services\ParkhausService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KassenautomatController extends Controller
{
    protected $parkhausService;

    public function __construct(ParkhausService $parkhausService)
    {
        $this->parkhausService = $parkhausService;
    }

    /**
     * Zeige zu zahlenden Betrag für ein Kennzeichen
     */
    public function zeigeBetrag(Request $request): JsonResponse
    {
        $request->validate([
            'kennzeichen' => 'required|string|max:20',
            'parkhaus_id' => 'required|integer|exists:parkhaeuser,id'
        ]);

        try {
            // Finde aktives Ticket
            $ticket = \App\Models\Ticket::whereHas('fahrzeug', function ($query) use ($request) {
                $query->where('kennzeichen', $request->kennzeichen);
            })
            ->where('parkhaus_id', $request->parkhaus_id)
            ->where('status', 'aktiv')
            ->first();

            if (!$ticket) {
                return response()->json([
                    'message' => 'Kein aktives Ticket für dieses Kennzeichen gefunden'
                ], 404);
            }

            if ($ticket->isDauerticket()) {
                return response()->json([
                    'message' => 'Dauerticket - keine Zahlung erforderlich',
                    'ticket_id' => $ticket->id,
                    'ticket_typ' => 'dauer',
                    'gueltig_bis' => $ticket->gueltig_bis
                ]);
            }

            $betrag = $this->parkhausService->berechneGebuehren($ticket->id);

            return response()->json([
                'ticket_id' => $ticket->id,
                'kennzeichen' => $request->kennzeichen,
                'einfahrts_zeit' => $ticket->einfahrts_zeit,
                'parkdauer_stunden' => $ticket->einfahrts_zeit->diffInHours(now()),
                'zu_zahlender_betrag' => $betrag,
                'preis_pro_stunde' => $ticket->parkhaus->preis_pro_stunde
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler beim Abrufen des Betrags',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verarbeite Barzahlung
     */
    public function barzahlung(Request $request): JsonResponse
    {
        $request->validate([
            'ticket_id' => 'required|integer|exists:tickets,id',
            'gezahlter_betrag' => 'required|numeric|min:0'
        ]);

        try {
            $zahlung = $this->parkhausService->verarbeiteZahlung(
                $request->ticket_id,
                'bar',
                $request->gezahlter_betrag
            );

            return response()->json([
                'message' => 'Barzahlung erfolgreich',
                'zahlung' => $zahlung,
                'rueckgeld' => $zahlung->rueckgeld
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler bei der Barzahlung',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verarbeite Kreditkartenzahlung
     */
    public function kreditkartenzahlung(Request $request): JsonResponse
    {
        $request->validate([
            'ticket_id' => 'required|integer|exists:tickets,id',
            'kreditkarten_nummer' => 'required|string|max:20',
            'gezahlter_betrag' => 'required|numeric|min:0'
        ]);

        try {
            $zahlung = $this->parkhausService->verarbeiteZahlung(
                $request->ticket_id,
                'kreditkarte',
                $request->gezahlter_betrag,
                $request->kreditkarten_nummer
            );

            return response()->json([
                'message' => 'Kreditkartenzahlung erfolgreich',
                'zahlung' => $zahlung
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler bei der Kreditkartenzahlung',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
