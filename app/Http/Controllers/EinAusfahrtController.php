<?php

namespace App\Http\Controllers;

use App\Services\ParkhausService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EinAusfahrtController extends Controller
{
    protected $parkhausService;

    public function __construct(ParkhausService $parkhausService)
    {
        $this->parkhausService = $parkhausService;
    }

    /**
     * Simuliere Einfahrt eines Fahrzeugs
     */
    public function einfahrt(Request $request): JsonResponse
    {
        $request->validate([
            'kennzeichen' => 'required|string|max:20',
            'parkhaus_id' => 'required|integer|exists:parkhaeuser,id',
            'kennzeichen_bild' => 'nullable|string'
        ]);

        try {
            $result = $this->parkhausService->einfahrt(
                $request->kennzeichen,
                $request->parkhaus_id,
                $request->kennzeichen_bild
            );

            return response()->json([
                'message' => 'Einfahrt erfolgreich',
                'ticket_id' => $result['ticket_id'],
                'parkplatz' => $result['parkplatz'],
                'schranke_geoeffnet' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler bei der Einfahrt',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Simuliere Ausfahrt eines Fahrzeugs
     */
    public function ausfahrt(Request $request): JsonResponse
    {
        $request->validate([
            'kennzeichen' => 'required|string|max:20',
            'parkhaus_id' => 'required|integer|exists:parkhaeuser,id',
            'kennzeichen_bild' => 'nullable|string'
        ]);

        try {
            $result = $this->parkhausService->ausfahrt(
                $request->kennzeichen,
                $request->parkhaus_id,
                $request->kennzeichen_bild
            );

            return response()->json([
                'message' => 'Ausfahrt erfolgreich',
                'ticket' => $result['ticket'],
                'parkplatz' => $result['parkplatz'],
                'schranke_geoeffnet' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler bei der Ausfahrt',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
