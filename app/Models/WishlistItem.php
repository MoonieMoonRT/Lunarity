<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $fillable = [
        'wishlist_id', 'room_type_id', 'quantity',
    ];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function getSubtotalAttribute(): float
    {
        $nights = $this->wishlist->nights;
        return $this->quantity * $this->roomType->price_per_night * $nights;
    }
}
