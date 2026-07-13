<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'date_of_birth',
        'gender',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function queueTickets(): HasMany
    {
        return $this->hasMany(QueueTicket::class);
    }

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-',
        };
    }
}