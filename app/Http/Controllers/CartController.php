<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $buyerId = auth()->id();

        $product = Product::where('product_id', $request->product_id)
            ->where('status', '!=', 'unavailable')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'This product is no longer available.'
            ], 404);
        }

        if ((int) $product->seller_id === (int) $buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot add your own product to your cart.'
            ], 403);
        }

        $alreadyAdded = DB::table('carts')
            ->where('buyer_id', $buyerId)
            ->where('product_id', $product->product_id)
            ->exists();

        if ($alreadyAdded) {
            return response()->json([
                'success' => false,
                'message' => 'This product is already in your cart!'
            ], 409);
        }

        $sellerName = DB::table('users')
            ->where('id', $product->seller_id)
            ->value('name');

        DB::table('carts')->insert([
            'buyer_id' => $buyerId,
            'seller_id' => $product->seller_id,
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'oum' => $product->oum,
            'seller_name' => $sellerName ?? '',
            'product_amount' => $product->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $product->product_name .
                ' was successfully added to your cart.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GET LOGGED-IN BUYER'S CART
    |--------------------------------------------------------------------------
    */

    public function getCartItems()
    {
        $cartItems = DB::table('carts')
            ->join(
                'products',
                'carts.product_id',
                '=',
                'products.product_id'
            )
            ->where('carts.buyer_id', auth()->id())
            ->select(
                'carts.cart_id',
                'carts.buyer_id',
                'carts.seller_id',
                'carts.product_id',
                'carts.product_name',
                'carts.oum',
                'carts.seller_name',
                'carts.product_amount',
                'products.image'
            )
            ->orderBy('carts.cart_id', 'desc')
            ->get();

        return response()->json($cartItems);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE ITEM FROM CART
    |--------------------------------------------------------------------------
    */

    public function removeFromCart($cartId)
    {
        $deleted = DB::table('carts')
            ->where('cart_id', $cartId)
            ->where('buyer_id', auth()->id())
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product successfully removed from your cart.'
        ]);
    }
}
