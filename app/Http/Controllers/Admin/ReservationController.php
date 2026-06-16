<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function create()
    {
        $users     = User::where('role', 'user')->orderBy('name')->get();
        $roomTypes = RoomType::all();

        return view('admin.reservations.create', compact('users', 'roomTypes'));
    }

    /**
     * Returns available rooms for a given room_type_id and date range (AJAX).
     */
    public function availableRooms(Request $request)
    {
        $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'check_in'     => ['required', 'date'],
            'check_out'    => ['required', 'date', 'after:check_in'],
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);
        $rooms    = $roomType->availableRooms($request->check_in, $request->check_out);

        return response()->json($rooms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => ['required', 'exists:users,id'],
            'check_in'     => ['required', 'date', 'after_or_equal:today'],
            'check_out'    => ['required', 'date', 'after:check_in'],
            'room_id'      => ['required', 'exists:rooms,id'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ]);

        $room     = Room::with('roomType')->findOrFail($request->room_id);
        $checkIn  = $request->check_in;
        $checkOut = $request->check_out;
        $nights   = \Carbon\Carbon::parse($checkIn)->diffInDays($checkOut);

        // Check availability
        $alreadyBooked = BookingDetail::whereHas('booking', function ($q) use ($checkIn, $checkOut) {
            $q->whereNotIn('status', ['cancelled'])
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        })->where('room_id', $room->id)->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['room_id' => 'This room is not available for the selected dates.']);
        }

        DB::transaction(function () use ($request, $room, $checkIn, $checkOut, $nights) {
            $subtotal = $room->roomType->price_per_night * $nights;

            $booking = Booking::create([
                'user_id'           => $request->user_id,
                'check_in'          => $checkIn,
                'check_out'         => $checkOut,
                'total_amount'      => $subtotal,
                'payment_method'    => 'admin',
                'status'            => 'active',
                'created_by_admin'  => true,
                'admin_id'          => Auth::id(),
                'notes'             => $request->notes,
            ]);

            BookingDetail::create([
                'booking_id'      => $booking->id,
                'room_id'         => $room->id,
                'room_type_id'    => $room->room_type_id,
                'price_per_night' => $room->roomType->price_per_night,
                'nights'          => $nights,
                'subtotal'        => $subtotal,
            ]);
        });

        return redirect()->route('admin.transactions')->with('success', 'Manual reservation created successfully.');
    }
}
