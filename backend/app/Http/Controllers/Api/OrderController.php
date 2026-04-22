<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order.id' => ['required', 'string', 'max:50'],
            'order.user_id' => ['nullable', 'integer'],
            'order.fullname' => ['required', 'string', 'max:255'],
            'order.phone' => ['required', 'string', 'max:30'],
            'order.address' => ['required', 'string'],
            'order.total_money' => ['required', 'integer', 'min:0'],
            'order.note' => ['nullable', 'string'],
            'order.shipping_method' => ['nullable', 'string', 'max:255'],
            'details' => ['required', 'array', 'min:1'],
            'details.*.id' => ['required', 'integer'],
            'details.*.soluong' => ['required', 'integer', 'min:1'],
            'details.*.price' => ['required', 'integer', 'min:0'],
            'details.*.note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data): void {
            $userEmail = null;
            if (! empty($data['order']['user_id'])) {
                $userEmail = DB::table('users')
                    ->where('id', $data['order']['user_id'])
                    ->value('email');
            }

            Order::create([
                'id' => $data['order']['id'],
                'user_id' => $data['order']['user_id'] ?? null,
                'fullname' => $data['order']['fullname'],
                'phone' => $data['order']['phone'],
                'email' => $userEmail,
                'address' => $data['order']['address'],
                'total_money' => $data['order']['total_money'],
                'shipping_fee' => 0,
                'discount_amount' => 0,
                'note' => $data['order']['note'] ?? null,
                'shipping_method' => $data['order']['shipping_method'] ?? null,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'shipping_status' => 'pending',
                'status' => 0,
            ]);

            foreach ($data['details'] as $item) {
                $product = Product::query()->find($item['id']);
                $subtotal = $item['price'] * $item['soluong'];

                OrderDetail::create([
                    'order_id' => $data['order']['id'],
                    'product_id' => $item['id'],
                    'product_title' => $product?->title,
                    'product_sku' => $product?->sku,
                    'product_image' => $product?->img,
                    'quantity' => $item['soluong'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                    'note' => $item['note'] ?? null,
                ]);

                if ($product && isset($product->stock_quantity)) {
                    $product->decrement('stock_quantity', min($product->stock_quantity, (int) $item['soluong']));
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Đặt hàng tại F&K STORE thành công!',
        ]);
    }
}
