<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user) {
            $wishlistItems = WishlistItem::where('user_id', $user->id)->get();
            if ($wishlistItems) {
                return view('fe.home.wishlist')->with(['wishlistItems' => $wishlistItems]);
            } else {
                return redirect()->route('fe.shop.index');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function adminIndex()
    {
        $wishlistItems = WishlistItem::all();
        return view('admin.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pId = $request->id;
        $loggedUser = auth()->user();
        if ($loggedUser) {
            $user = User::find($loggedUser->id);
            $user->wishlistItems()->create(['product_id' => $pId]);
            return response()->json(['message' => 'Wishlist saved successfully', 'totalWishlist' => count(auth()->user()->wishlistItems)]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function show(WishlistItem $wishlistItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function edit(WishlistItem $wishlistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishlistItem $wishlistItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(Request $request)
    {
        $pId = $request->id;
        $user = auth()->user();
        $userId = $user->id;
        $wishlistItem = WishlistItem::where('user_id', $userId)->where('product_id', $pId)->first();
        $wishlistItem->delete();
        return response()->json(['message' => 'Wishlist deleted successfully', 'totalWishlist' => count(auth()->user()->wishlistItems)]);
    }

    public function adminDestroy(Request $request)
    {
        $wlId = $request->id;
        $wishlistItem = WishlistItem::where('id', $wlId)->first();
        $wishlistItem->delete();
        return back();
    }


}
