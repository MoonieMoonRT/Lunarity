<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_code', 'user_id', 'wishlist_id', 'check_in', 'check_out',
        'total_amount', 'payment_method', 'status', 'created_by_admin',
        'admin_id', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in'          => 'date',
            'check_out'         => 'date',
            'total_amount'      => 'decimal:2',
            'created_by_admin'  => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'LNR-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getNightsAttribute(): int
    {
        return (int) $this->check_in->diffInDays($this->check_out);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'active'    => 'success',
            'completed' => 'info',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}
