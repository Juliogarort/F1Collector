<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->wishlist()->with('products')->first();
        return view('wishlist.index', compact('wishlist'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $wishlist = $user->wishlist ?: $user->wishlist()->create();

        $exists = $wishlist->products()->where('product_id', $product->id)->exists();

        if ($exists) {
            $wishlist->products()->detach($product->id);
            return back()->with('success', 'Producto eliminado de tu lista de deseos.');
        } else {
            $wishlist->products()->attach($product->id);
            return back()->with('success', 'Producto añadido a tu lista de deseos.');
        }
    }
}
