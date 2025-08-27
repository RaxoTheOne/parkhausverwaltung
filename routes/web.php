<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkhausController;
use App\Http\Controllers\EinAusfahrtController;
use App\Http\Controllers\KassenautomatController;

Route::get('/', function () {
    return view('parkhaus');
});

// Parkhausverwaltung API Routes
Route::prefix('api/parkhaus')->group(function () {
    Route::get('/', [ParkhausController::class, 'index']);
    Route::post('/', [ParkhausController::class, 'store']);
    Route::get('/{parkhaus}', [ParkhausController::class, 'show']);
    Route::put('/{parkhaus}', [ParkhausController::class, 'update']);
    Route::delete('/{parkhaus}', [ParkhausController::class, 'destroy']);
});

// Ein- und Ausfahrt API Routes
Route::prefix('api/ein-ausfahrt')->group(function () {
    Route::post('/einfahrt', [EinAusfahrtController::class, 'einfahrt']);
    Route::post('/ausfahrt', [EinAusfahrtController::class, 'ausfahrt']);
});

// Kassenautomat API Routes
Route::prefix('api/kassenautomat')->group(function () {
    Route::post('/zeige-betrag', [KassenautomatController::class, 'zeigeBetrag']);
    Route::post('/barzahlung', [KassenautomatController::class, 'barzahlung']);
    Route::post('/kreditkartenzahlung', [KassenautomatController::class, 'kreditkartenzahlung']);
});
