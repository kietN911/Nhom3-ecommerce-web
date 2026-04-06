<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Place Order (Checkout)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $userId = $request->user_id;

        // 1. Get cart items
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        // 2. Validate empty cart
        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart is empty'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // 3. Calculate total price
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }

            // 4. Create Order
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            // 5. Create OrderDetails
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // 6. Clear Cart
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => $order->load('orderDetails')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
    }
}
