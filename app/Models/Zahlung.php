<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zahlung extends Model
{
    use HasFactory;

    protected $table = 'zahlungen';

    protected $fillable = [
        'ticket_id',
        'zahlungsart',
        'betrag',
        'rueckgeld',
        'kreditkarten_nummer',
        'zahlungs_zeit',
        'status'
    ];

    protected $casts = [
        'betrag' => 'decimal:2',
        'rueckgeld' => 'decimal:2',
        'zahlungs_zeit' => 'datetime'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function isBarzahlung(): bool
    {
        return $this->zahlungsart === 'bar';
    }

    public function isKreditkarte(): bool
    {
        return $this->zahlungsart === 'kreditkarte';
    }
}
