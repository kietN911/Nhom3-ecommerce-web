<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'count_users' => User::query()->where('user_type', 0)->count(),
            'count_products' => Product::query()->where('status', 1)->count(),
            'total_revenue' => (int) Order::query()->where('status', 1)->sum('total_money'),
        ]);
    }

    public function users(): JsonResponse
    {
        return response()->json(
            User::query()
                ->where('user_type', 0)
                ->orderByDesc('id')
                ->get(['id', 'fullname', 'phone', 'created_at', 'status'])
        );
    }

    public function orders(): JsonResponse
    {
        return response()->json(
            Order::query()
                ->orderByDesc('order_date')
                ->get(['id', 'fullname', 'phone', 'order_date', 'total_money', 'status'])
        );
    }

    public function products(): JsonResponse
    {
        return response()->json(
            Product::query()
                ->where('status', 1)
                ->orderByDesc('id')
                ->get()
        );
    }

    public function storeProduct(Request $request): JsonResponse
    {
        $data = $this->validateProduct($request);

        $product = Product::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Lưu sản phẩm thành công!',
            'product' => $product,
        ]);
    }

    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        $data = $this->validateProduct($request, $product->img);
        $product->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $product->fresh(),
        ]);
    }

    public function deleteProduct(Product $product): JsonResponse
    {
        $product->update(['status' => 0]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa sản phẩm.',
        ]);
    }

    public function toggleUser(User $user): JsonResponse
    {
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật trạng thái tài khoản.',
            'user' => $user->only(['id', 'status']),
        ]);
    }

    public function confirmOrder(Order $order): JsonResponse
    {
        $order->update(['status' => 1]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã duyệt đơn hàng.',
        ]);
    }

    private function validateProduct(Request $request, ?string $currentImage = null): array
    {
        $validated = $request->validate([
            'ten-mon' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'gia-moi' => ['required', 'integer', 'min:0'],
            'mo-ta' => ['nullable', 'string'],
            'current_img' => ['nullable', 'string'],
            'up-hinh-anh' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = $validated['current_img'] ?? $currentImage ?? './assets/img/blank-image.png';

        if ($request->hasFile('up-hinh-anh')) {
            $file = $request->file('up-hinh-anh');
            $targetDir = base_path('../frontend/assets/img/products');
            File::ensureDirectoryExists($targetDir);
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move($targetDir, $filename);
            $imagePath = './assets/img/products/'.$filename;
        }

        return [
            'title' => $validated['ten-mon'],
            'category' => $validated['category'] ?? null,
            'price' => $validated['gia-moi'],
            'description' => $validated['mo-ta'] ?? null,
            'img' => $imagePath,
            'status' => 1,
        ];
    }
}
