<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'parkhaus_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function parkhaus()
    {
        return $this->belongsTo(Parkhaus::class);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isParkhausAdmin()
    {
        return $this->role === 'parkhaus_admin';
    }

    public function canManageParkhaus($parkhausId)
    {
        return $this->isSuperAdmin() ||
               ($this->isParkhausAdmin() && $this->parkhaus_id == $parkhausId);
    }
}
