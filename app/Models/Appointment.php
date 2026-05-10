<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'staff_id', 'service_id', 'slot_id', 'status', 'remarks', 'booked_at'
    ];

    protected $casts = [
        'booked_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'slot_id');
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'pending'   => 'badge-warning',
            'approved'  => 'badge-primary',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            default     => 'badge-secondary',
        };
    }
}
