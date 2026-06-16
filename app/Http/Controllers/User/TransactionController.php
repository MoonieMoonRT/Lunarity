<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Services\BookingStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Show the transaction/checkout page with wishlist items.
     */
    public function index()
    {
        $wishlist  = $this->getActiveWishlist();
        $roomTypes = RoomType::all();
        return view('user.transactions.index', compact('wishlist', 'roomTypes'));
    }

    /**
     * Update the quantity of a wishlist item.
     */
    public function updateQuantity(WishlistItem $item, Request $request)
    {
        $request->validate(['action' => ['required', 'in:increase,decrease']]);
        $this->authorizeItem($item);

        if ($request->action === 'increase') {
            $item->increment('quantity');
        } elseif ($request->action === 'decrease') {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                $item->delete();
            }
        }

        return back()->with('success', 'Quantity updated.');
    }

    /**
     * Remove a single item from the wishlist.
     */
    public function removeItem(WishlistItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();
        return back()->with('success', 'Item removed.');
    }

    /**
     * Set check-in/check-out dates on the active wishlist.
     */
    public function setDates(Request $request)
    {
        $request->validate([
            'check_in'  => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $wishlist = $this->getActiveWishlist();
        if (!$wishlist) {
            return back()->withErrors(['wishlist' => 'No active wishlist found.']);
        }

        $wishlist->update([
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
        ]);

        return redirect()->route('user.transactions.room-select');
    }

    /**
     * Show the room selection matrix.
     */
    public function showRoomSelect()
    {
        $wishlist = $this->getActiveWishlist();

        if (!$wishlist || !$wishlist->check_in || !$wishlist->check_out) {
            return redirect()->route('user.transactions')->withErrors(['dates' => 'Please select check-in and check-out dates first.']);
        }

        $wishlist->load('items.roomType');

        // Build availability matrix: available rooms per type
        $availability = [];
        foreach ($wishlist->items as $item) {
            $availableRooms = $item->roomType->availableRooms(
                $wishlist->check_in->toDateString(),
                $wishlist->check_out->toDateString()
            );

            $availability[$item->id] = [
                'item'       => $item,
                'room_type'  => $item->roomType,
                'quantity'   => $item->quantity,
                'rooms'      => $availableRooms->groupBy('view_type'),
                'has_enough' => $availableRooms->count() >= $item->quantity,
            ];
        }

        return view('user.transactions.room-select', compact('wishlist', 'availability'));
    }

    /**
     * Store selected rooms in session.
     */
    public function selectRooms(Request $request)
    {
        $wishlist = $this->getActiveWishlist();
        $wishlist->load('items.roomType');

        $selected = $request->input('selected_rooms', []);

        // Validate: for each wishlist item, correct number of rooms selected
        $errors = [];
        foreach ($wishlist->items as $item) {
            $roomTypeId    = $item->room_type_id;
            $selectedForType = $selected[$roomTypeId] ?? [];

            if (count($selectedForType) !== $item->quantity) {
                $errors[] = "Please select exactly {$item->quantity} {$item->roomType->name}(s).";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        session(['selected_rooms' => $selected]);

        return redirect()->route('user.transactions.confirm');
    }

    /**
     * Show order confirmation + payment method selection.
     */
    public function showConfirm()
    {
        $wishlist = $this->getActiveWishlist();

        if (!$wishlist || !session('selected_rooms')) {
            return redirect()->route('user.transactions.room-select');
        }

        $wishlist->load('items.roomType');

        $selectedRooms = session('selected_rooms');
        $rooms         = Room::with('roomType')->whereIn('id', collect($selectedRooms)->flatten()->toArray())->get()->keyBy('id');
        $nights        = $wishlist->nights;

        // Build order summary
        $orderLines = [];
        $total      = 0;

        foreach ($wishlist->items as $item) {
            $roomTypeId = $item->room_type_id;
            $roomIds    = $selectedRooms[$roomTypeId] ?? [];
            foreach ($roomIds as $roomId) {
                $room      = $rooms[$roomId];
                $subtotal  = $item->roomType->price_per_night * $nights;
                $total    += $subtotal;
                $orderLines[] = [
                    'room'            => $room,
                    'room_type'       => $item->roomType,
                    'price_per_night' => $item->roomType->price_per_night,
                    'nights'          => $nights,
                    'subtotal'        => $subtotal,
                ];
            }
        }

        return view('user.transactions.confirm', compact('wishlist', 'orderLines', 'total'));
    }

    /**
     * Create the booking (order).
     */
    public function order(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'in:qris,credit_card,cash'],
        ]);

        $wishlist = $this->getActiveWishlist();

        if (!$wishlist || !session('selected_rooms')) {
            return redirect()->route('user.transactions');
        }

        $wishlist->load('items.roomType');
        $selectedRooms = session('selected_rooms');
        $nights        = $wishlist->nights;

        DB::transaction(function () use ($wishlist, $selectedRooms, $nights, $request) {
            $total = 0;
            $lines = [];

            foreach ($wishlist->items as $item) {
                $roomIds = $selectedRooms[$item->room_type_id] ?? [];
                foreach ($roomIds as $roomId) {
                    $subtotal = $item->roomType->price_per_night * $nights;
                    $total   += $subtotal;
                    $lines[]  = [
                        'room_id'         => $roomId,
                        'room_type_id'    => $item->room_type_id,
                        'price_per_night' => $item->roomType->price_per_night,
                        'nights'          => $nights,
                        'subtotal'        => $subtotal,
                    ];
                }
            }

            $booking = Booking::create([
                'user_id'        => Auth::id(),
                'wishlist_id'    => $wishlist->id,
                'check_in'       => $wishlist->check_in,
                'check_out'      => $wishlist->check_out,
                'total_amount'   => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            foreach ($lines as $line) {
                BookingDetail::create(array_merge($line, ['booking_id' => $booking->id]));
            }

            // Close the wishlist
            $wishlist->update(['status' => 'checked_out']);
        });

        session()->forget('selected_rooms');

        return redirect()->route('user.bookings')->with('success', 'Booking confirmed! Your reservation is pending confirmation.');
    }

    /**
     * Booking history for the authenticated user.
     */
    public function history(BookingStatusService $statusService)
    {
        // Auto-sync statuses based on today's date before displaying
        $statusService->sync();

        $bookings = Booking::where('user_id', Auth::id())
                            ->with('details.room', 'details.roomType')
                            ->latest()
                            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * Show a single booking detail.
     */
    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        $booking->load('details.room', 'details.roomType');
        return view('user.bookings.show', compact('booking'));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getActiveWishlist(): ?Wishlist
    {
        return Wishlist::where('user_id', Auth::id())
                        ->where('status', 'open')
                        ->with('items.roomType')
                        ->latest()
                        ->first();
    }

    private function authorizeItem(WishlistItem $item): void
    {
        $wishlist = Wishlist::findOrFail($item->wishlist_id);
        abort_unless($wishlist->user_id === Auth::id(), 403);
    }
}
