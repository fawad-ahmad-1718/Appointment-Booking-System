<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', 'service_id', 'date', 'start_time', 'end_time', 'is_booked', 'status'
    ];

    protected $casts = [
        'date'      => 'date',
        'is_booked' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'slot_id');
    }

    public function isAvailable(): bool
    {
        return !$this->is_booked && $this->status === 'available';
    }
}
