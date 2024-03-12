<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        
        $wishlist = Wishlist::with('gallery', 'user')->where(['user_id' => $user_id])->get();

        return response()->json($wishlist);
    }

    public function store($id)
    {
        $gallery = Gallery::with('wishlists')->find($id);

        $wishlist = new Wishlist;
        $wishlist->user()->associate(Auth::user());
        $wishlist->gallery()->associate($gallery->id);
        
        $wishlist->save();
        $wishlist->load('gallery');

        return response()->json($wishlist);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);
        $wishlist->delete();

        return response()->noContent();
    }
}
