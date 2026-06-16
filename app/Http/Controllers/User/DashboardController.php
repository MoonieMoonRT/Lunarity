<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $roomTypes     = RoomType::all();
        $activeWishlist = Wishlist::where('user_id', Auth::id())
                                   ->where('status', 'open')
                                   ->with('items')
                                   ->latest()
                                   ->first();
        $wishlistCount  = $activeWishlist ? $activeWishlist->items->sum('quantity') : 0;

        return view('user.dashboard', compact('roomTypes', 'activeWishlist', 'wishlistCount'));
    }
}
