<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id', 'check_in', 'check_out', 'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in'  => 'date',
            'check_out' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getTotalRoomsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    public function getNightsAttribute(): int
    {
        if ($this->check_in && $this->check_out) {
            return (int) $this->check_in->diffInDays($this->check_out);
        }
        return 0;
    }

    public function getEstimatedTotalAttribute(): float
    {
        $nights = $this->nights;
        return $this->items->sum(function ($item) use ($nights) {
            return $item->quantity * $item->roomType->price_per_night * $nights;
        });
    }
}
