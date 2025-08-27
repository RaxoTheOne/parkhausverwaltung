<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parkhaus extends Model
{
    use HasFactory;

    protected $table = 'parkhaeuser';

    protected $fillable = [
        'name',
        'anzahl_ebenen',
        'parkplaetze_pro_ebene',
        'preis_pro_stunde'
    ];

    protected $casts = [
        'preis_pro_stunde' => 'decimal:2',
        'anzahl_ebenen' => 'integer',
        'parkplaetze_pro_ebene' => 'integer'
    ];

    public function parkplaetze(): HasMany
    {
        return $this->hasMany(Parkplatz::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function einAusfahrten(): HasMany
    {
        return $this->hasMany(EinAusfahrt::class);
    }

    public function getFreiePlaetzeAttribute(): int
    {
        return $this->parkplaetze()->where('status', 'frei')->count();
    }

    public function getGesamtPlaetzeAttribute(): int
    {
        return $this->anzahl_ebenen * $this->parkplaetze_pro_ebene;
    }

    public function getBelegtePlaetzeAttribute(): int
    {
        return $this->parkplaetze()->where('status', 'besetzt')->count();
    }
}
