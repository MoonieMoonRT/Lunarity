<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingStatusService;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(BookingStatusService $statusService)
    {
        $statusService->sync();
        $totalUsers     = User::where('role', 'user')->count();
        $totalBookings  = Booking::count();
        $pendingCount   = Booking::where('status', 'pending')->count();
        $activeCount    = Booking::where('status', 'active')->count();
        $completedCount = Booking::where('status', 'completed')->count();
        $cancelledCount = Booking::where('status', 'cancelled')->count();
        $totalRevenue   = Booking::whereIn('status', ['active', 'completed'])->sum('total_amount');
        $totalRooms     = Room::where('is_active', true)->count();

        // Occupancy: rooms booked today vs total
        $today = now()->toDateString();
        $bookedToday = \App\Models\BookingDetail::whereHas('booking', function ($q) use ($today) {
            $q->whereNotIn('status', ['cancelled'])
              ->where('check_in', '<=', $today)
              ->where('check_out', '>', $today);
        })->distinct('room_id')->count('room_id');

        $occupancyRate = $totalRooms > 0 ? round(($bookedToday / $totalRooms) * 100, 1) : 0;

        $recentBookings = Booking::with('user', 'details.roomType')
                                  ->latest()
                                  ->take(10)
                                  ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalBookings', 'pendingCount', 'activeCount',
            'completedCount', 'cancelledCount', 'totalRevenue',
            'occupancyRate', 'bookedToday', 'totalRooms', 'recentBookings'
        ));
    }
}
