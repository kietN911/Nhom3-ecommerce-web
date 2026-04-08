<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lấy danh sách sản phẩm + Tìm kiếm theo tên + Lọc theo loại hàng
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Tìm kiếm theo từ khóa
        if ($request->has('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 2. Lọc theo danh mục
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm',
            'data' => $products
        ], 200);
    }

    // Xem chi tiết 1 sản phẩm
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }
}
