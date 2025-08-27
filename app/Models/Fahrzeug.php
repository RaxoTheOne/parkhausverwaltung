<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fahrzeug extends Model
{
    use HasFactory;

    protected $table = 'fahrzeuge';

    protected $fillable = [
        'kennzeichen',
        'marke',
        'modell',
        'farbe'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function einAusfahrten(): HasMany
    {
        return $this->hasMany(EinAusfahrt::class);
    }
}
