<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueTicket extends Model
{
    protected $fillable = [
        'patient_id',
        'polyclinic_id',
        'doctor_id',
        'queue_code',
        'queue_date',
        'status',
        'estimated_waiting_minutes',
        'complaint',
        'called_at',
        'finished_at',
    ];

    protected $casts = [
        'queue_date' => 'date',
        'called_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}