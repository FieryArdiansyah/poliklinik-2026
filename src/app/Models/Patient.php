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
}