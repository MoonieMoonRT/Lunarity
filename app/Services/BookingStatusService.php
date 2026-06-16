<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class BookingStatusService
{
    /**
     * Auto-update booking statuses based on today's date.
     * Called on page load — no cron needed.
     *
     * Rules:
     *   pending  + today >= check_in  + today < check_out  → active
     *   pending  + today >= check_out                       → completed
     *   active   + today >= check_out                       → completed
     */
    public function sync(): void
    {
        $today = Carbon::today()->toDateString();

        // pending → active  (check-in day has arrived, not yet checked out)
        Booking::where('status', 'pending')
               ->where('check_in', '<=', $today)
               ->where('check_out', '>', $today)
               ->update(['status' => 'active']);

        // pending → completed  (somehow missed the active window entirely)
        Booking::where('status', 'pending')
               ->where('check_out', '<=', $today)
               ->update(['status' => 'completed']);

        // active → completed  (check-out day has passed)
        Booking::where('status', 'active')
               ->where('check_out', '<=', $today)
               ->update(['status' => 'completed']);
    }
}
