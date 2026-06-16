<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * View the current active wishlist.
     */
    public function index()
    {
        $wishlist = $this->getOrCreateWishlist();
        $wishlist->load('items.roomType');
        return view('user.wishlist', compact('wishlist'));
    }

    /**
     * Add a room type to the wishlist.
     */
    public function add(Request $request)
    {
        $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
        ]);

        $wishlist = $this->getOrCreateWishlist();

        $item = WishlistItem::where('wishlist_id', $wishlist->id)
                             ->where('room_type_id', $request->room_type_id)
                             ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            WishlistItem::create([
                'wishlist_id'  => $wishlist->id,
                'room_type_id' => $request->room_type_id,
                'quantity'     => 1,
            ]);
        }

        return back()->with('success', 'Room added to wishlist!');
    }

    /**
     * Remove a specific wishlist item.
     */
    public function remove(WishlistItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();
        return back()->with('success', 'Item removed from wishlist.');
    }

    /**
     * Clear the entire active wishlist.
     */
    public function clear()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                             ->where('status', 'open')
                             ->latest()
                             ->first();
        if ($wishlist) {
            $wishlist->items()->delete();
            $wishlist->delete();
        }
        return back()->with('success', 'Wishlist cleared.');
    }

    private function getOrCreateWishlist(): Wishlist
    {
        return Wishlist::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'open'],
            ['check_in' => null, 'check_out' => null]
        );
    }
}
