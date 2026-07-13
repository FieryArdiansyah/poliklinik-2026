<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueTicket extends Model
{
    public const STATUS_WAITING = 'waiting';
    public const STATUS_CALLED = 'called';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELLED = 'cancelled';

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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_WAITING => 'Menunggu',
            self::STATUS_CALLED => 'Dipanggil',
            self::STATUS_DONE => 'Selesai',
            self::STATUS_CANCELLED => 'Batal',
            default => $this->status,
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_WAITING => 'status-waiting',
            self::STATUS_CALLED => 'status-called',
            self::STATUS_DONE => 'status-done',
            self::STATUS_CANCELLED => 'status-cancelled',
            default => 'status-waiting',
        };
    }
}