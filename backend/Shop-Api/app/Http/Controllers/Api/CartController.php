<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * View Cart
     */
    public function index(Request $request)
    {
        if (!$request->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID is required'
            ], 400);
        }

        $userId = $request->user_id;

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $cartItems,
            'total_items' => $cartItems->count()
        ]);
    }

    /**
     * Add to Cart
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $cart = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            $cart = Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        $product = Product::find($request->product_id);
        $totalItems = Cart::where('user_id', $request->user_id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'data' => $cart,
            'product' => $product,
            'total_items' => $totalItems
        ]);
    }

    /**
     * Delete Cart (Clear all items for a user)
     */
    public function destroy(Request $request)
    {
        $userId = $request->input('user_id');
        
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID is required'
            ], 400);
        }

        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully'
        ]);
    }
}
