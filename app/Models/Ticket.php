<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'fahrzeug_id',
        'parkhaus_id',
        'ticket_typ',
        'einfahrts_zeit',
        'ausfahrts_zeit',
        'gezahlter_betrag',
        'status',
        'gueltig_bis'
    ];

    protected $casts = [
        'einfahrts_zeit' => 'datetime',
        'ausfahrts_zeit' => 'datetime',
        'gezahlter_betrag' => 'decimal:2',
        'gueltig_bis' => 'datetime'
    ];

    public function fahrzeug(): BelongsTo
    {
        return $this->belongsTo(Fahrzeug::class);
    }

    public function parkhaus(): BelongsTo
    {
        return $this->belongsTo(Parkhaus::class);
    }

    public function zahlungen(): HasMany
    {
        return $this->hasMany(Zahlung::class);
    }

    public function isDauerticket(): bool
    {
        return $this->ticket_typ === 'dauer';
    }

    public function isAktiv(): bool
    {
        return $this->status === 'aktiv';
    }
}
