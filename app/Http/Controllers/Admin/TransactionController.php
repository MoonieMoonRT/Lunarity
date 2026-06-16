<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Services\BookingStatusService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, BookingStatusService $statusService)
    {
        $statusService->sync();

        $users   = User::where('role', 'user')->orderBy('name')->get();
        $bookings = collect();
        $selectedUser = null;

        if ($request->filled('user_id')) {
            $selectedUser = User::find($request->user_id);
            $bookings = Booking::where('user_id', $request->user_id)
                                ->with('details.room', 'details.roomType')
                                ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
                                ->latest()
                                ->paginate(10)
                                ->withQueryString();
        }

        return view('admin.transactions.index', compact('users', 'bookings', 'selectedUser'));
    }

    public function show(Booking $booking)
    {
        $booking->load('user', 'details.room', 'details.roomType', 'admin');
        return view('admin.transactions.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:pending,active,completed,cancelled'],
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated to ' . ucfirst($request->status) . '.');
    }
}
