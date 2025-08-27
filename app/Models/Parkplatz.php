<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parkplatz extends Model
{
    use HasFactory;

    protected $table = 'parkplaetze';

    protected $fillable = [
        'parkhaus_id',
        'ebene',
        'parkplatz_nummer',
        'status'
    ];

    protected $casts = [
        'ebene' => 'integer',
        'parkplatz_nummer' => 'integer'
    ];

    public function parkhaus(): BelongsTo
    {
        return $this->belongsTo(Parkhaus::class);
    }
}
