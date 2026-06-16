<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_type_id', 'room_number', 'view_type', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getViewTypeLabelAttribute(): string
    {
        return match ($this->view_type) {
            'city'  => 'City View',
            'sea'   => 'Sea View',
            'pool'  => 'Pool View',
            default => ucfirst($this->view_type),
        };
    }

    public function getViewTypeBadgeAttribute(): string
    {
        return match ($this->view_type) {
            'city'  => 'bg-info',
            'sea'   => 'bg-primary',
            'pool'  => 'bg-success',
            default => 'bg-secondary',
        };
    }
}
