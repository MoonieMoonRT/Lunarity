<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id', 'room_id', 'room_type_id',
        'price_per_night', 'nights', 'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
            'subtotal'        => 'decimal:2',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
