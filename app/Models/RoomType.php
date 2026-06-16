<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'short_description',
        'price_per_night', 'max_capacity', 'image_url',
    ];

    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    /**
     * Get available rooms for a given date range.
     */
    public function availableRooms(string $checkIn, string $checkOut)
    {
        $bookedRoomIds = BookingDetail::whereHas('booking', function ($q) use ($checkIn, $checkOut) {
            $q->whereNotIn('status', ['cancelled'])
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        })->where('room_type_id', $this->id)->pluck('room_id');

        return $this->rooms()
                    ->where('is_active', true)
                    ->whereNotIn('id', $bookedRoomIds)
                    ->orderBy('room_number')
                    ->get();
    }
}
