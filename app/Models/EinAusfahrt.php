<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EinAusfahrt extends Model
{
    use HasFactory;

    protected $table = 'ein_ausfahrten';

    protected $fillable = [
        'parkhaus_id',
        'fahrzeug_id',
        'richtung',
        'zeitpunkt',
        'kennzeichen_bild_pfad',
        'schranke_geoeffnet',
        'bemerkungen'
    ];

    protected $casts = [
        'zeitpunkt' => 'datetime',
        'schranke_geoeffnet' => 'boolean'
    ];

    public function parkhaus(): BelongsTo
    {
        return $this->belongsTo(Parkhaus::class);
    }

    public function fahrzeug(): BelongsTo
    {
        return $this->belongsTo(Fahrzeug::class);
    }

    public function isEinfahrt(): bool
    {
        return $this->richtung === 'einfahrt';
    }

    public function isAusfahrt(): bool
    {
        return $this->richtung === 'ausfahrt';
    }
}
