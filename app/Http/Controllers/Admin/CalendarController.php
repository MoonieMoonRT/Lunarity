<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar');
    }

    /**
     * Returns booking events for FullCalendar as JSON.
     */
    public function data(Request $request)
    {
        $query = Booking::with('user', 'details.room', 'details.roomType')
                         ->whereNotIn('status', ['cancelled']);

        if ($request->filled('start')) {
            $query->where('check_out', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->where('check_in', '<=', $request->end);
        }

        $events = $query->get()->map(function ($booking) {
            $rooms = $booking->details->map(fn($d) => $d->room->room_number)->join(', ');
            return [
                'id'    => $booking->id,
                'title' => "[{$booking->booking_code}] {$booking->user->name} — {$rooms}",
                'start' => $booking->check_in->toDateString(),
                'end'   => $booking->check_out->toDateString(),
                'color' => match ($booking->status) {
                    'active'    => '#2a9d8f',
                    'pending'   => '#e9c46a',
                    'completed' => '#264653',
                    default     => '#999',
                },
                'url'   => route('admin.transactions.show', $booking->id),
            ];
        });

        return response()->json($events);
    }
}
