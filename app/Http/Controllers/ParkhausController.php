<?php

namespace App\Http\Controllers;

use App\Models\Parkhaus;
use App\Services\ParkhausService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ParkhausController extends Controller
{
    protected $parkhausService;

    public function __construct(ParkhausService $parkhausService)
    {
        $this->parkhausService = $parkhausService;
    }

    /**
     * Zeige alle Parkhäuser mit Status
     */
    public function index(): JsonResponse
    {
        $parkhaeuser = Parkhaus::with(['parkplaetze'])->get();

        $data = $parkhaeuser->map(function ($parkhaus) {
            return [
                'id' => $parkhaus->id,
                'name' => $parkhaus->name,
                'anzahl_ebenen' => $parkhaus->anzahl_ebenen,
                'parkplaetze_pro_ebene' => $parkhaus->parkplaetze_pro_ebene,
                'preis_pro_stunde' => $parkhaus->preis_pro_stunde,
                'freie_plaetze' => $parkhaus->freie_plaetze,
                'belegte_plaetze' => $parkhaus->belegte_plaetze,
                'gesamt_plaetze' => $parkhaus->gesamt_plaetze
            ];
        });

        return response()->json($data);
    }

    /**
     * Erstelle ein neues Parkhaus
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'anzahl_ebenen' => 'required|integer|min:1|max:10',
            'parkplaetze_pro_ebene' => 'required|integer|min:1|max:100',
            'preis_pro_stunde' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $parkhaus = $this->parkhausService->createParkhaus($request->all());

            return response()->json([
                'message' => 'Parkhaus erfolgreich erstellt',
                'parkhaus' => $parkhaus
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler beim Erstellen des Parkhauses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Zeige Details eines Parkhauses
     */
    public function show(Parkhaus $parkhaus): JsonResponse
    {
        $parkhaus->load(['parkplaetze', 'tickets']);

        return response()->json([
            'id' => $parkhaus->id,
            'name' => $parkhaus->name,
            'anzahl_ebenen' => $parkhaus->anzahl_ebenen,
            'parkplaetze_pro_ebene' => $parkhaus->parkplaetze_pro_ebene,
            'preis_pro_stunde' => $parkhaus->preis_pro_stunde,
            'freie_plaetze' => $parkhaus->freie_plaetze,
            'belegte_plaetze' => $parkhaus->belegte_plaetze,
            'gesamt_plaetze' => $parkhaus->gesamt_plaetze,
            'parkplaetze' => $parkhaus->parkplaetze->groupBy('ebene'),
            'aktive_tickets' => $parkhaus->tickets->where('status', 'aktiv')->count()
        ]);
    }

    /**
     * Aktualisiere ein Parkhaus
     */
    public function update(Request $request, Parkhaus $parkhaus): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'preis_pro_stunde' => 'sometimes|numeric|min:0|max:100'
        ]);

        $parkhaus->update($request->only(['name', 'preis_pro_stunde']));

        return response()->json([
            'message' => 'Parkhaus erfolgreich aktualisiert',
            'parkhaus' => $parkhaus
        ]);
    }

    /**
     * Lösche ein Parkhaus
     */
    public function destroy(Parkhaus $parkhaus): JsonResponse
    {
        $parkhaus->delete();

        return response()->json([
            'message' => 'Parkhaus erfolgreich gelöscht'
        ]);
    }
}
