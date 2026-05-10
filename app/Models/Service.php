<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'price', 'status'];

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
