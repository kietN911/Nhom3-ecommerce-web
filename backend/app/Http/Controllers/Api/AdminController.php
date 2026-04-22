<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $productQuery = Product::query();
        if (Schema::hasColumn('products', 'status')) {
            $productQuery->where('status', 1);
        }

        $orderQuery = Order::query();
        if (Schema::hasColumn('orders', 'status')) {
            $orderQuery->where('status', 1);
        }

        $userQuery = User::query();
        if (Schema::hasColumn('users', 'user_type')) {
            $userQuery->where('user_type', 0);
        }

        return response()->json([
            'count_users' => $userQuery->count(),
            'count_products' => $productQuery->count(),
            'total_revenue' => (int) $orderQuery->sum('total_money'),
        ]);
    }

    public function users(): JsonResponse
    {
        $query = User::query()->orderByDesc('id');
        if (Schema::hasColumn('users', 'user_type')) {
            $query->where('user_type', 0);
        }

        $columns = ['id', 'fullname', 'phone'];
        if (Schema::hasColumn('users', 'created_at')) {
            $columns[] = 'created_at';
        }
        if (Schema::hasColumn('users', 'status')) {
            $columns[] = 'status';
        }

        return response()->json(
            $query->get($columns)
        );
    }

    public function orders(): JsonResponse
    {
        $columns = ['id', 'fullname', 'phone', 'total_money'];
        if (Schema::hasColumn('orders', 'order_date')) {
            $columns[] = 'order_date';
        }
        if (Schema::hasColumn('orders', 'status')) {
            $columns[] = 'status';
        }

        return response()->json(
            Order::query()
                ->orderByDesc('order_date')
                ->get($columns)
        );
    }

    public function products(): JsonResponse
    {
        $query = Product::query()->orderByDesc('id');
        if (Schema::hasColumn('products', 'status')) {
            $query->where('status', 1);
        }

        return response()->json(
            $query->get()
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
        if (Schema::hasColumn('products', 'status')) {
            $product->update(['status' => 0]);
        } else {
            $product->delete();
        }

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
            ...(Schema::hasColumn('products', 'status') ? ['status' => 1] : []),
        ];
    }
}
