<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
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
            Order::create([
                'id' => $data['order']['id'],
                'user_id' => $data['order']['user_id'] ?? null,
                'fullname' => $data['order']['fullname'],
                'phone' => $data['order']['phone'],
                'address' => $data['order']['address'],
                'total_money' => $data['order']['total_money'],
                'note' => $data['order']['note'] ?? null,
                'shipping_method' => $data['order']['shipping_method'] ?? null,
                'status' => 0,
            ]);

            foreach ($data['details'] as $item) {
                OrderDetail::create([
                    'order_id' => $data['order']['id'],
                    'product_id' => $item['id'],
                    'quantity' => $item['soluong'],
                    'price' => $item['price'],
                    'note' => $item['note'] ?? null,
                ]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Đặt hàng tại F&K STORE thành công!',
        ]);
    }
}
