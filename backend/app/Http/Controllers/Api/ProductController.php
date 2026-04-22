<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()->where('status', 1)->orderByDesc('id');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->string('search')->toString().'%');
        }

        if ($request->filled('category') && $request->string('category')->toString() !== 'Tất cả') {
            $query->where('category', $request->string('category')->toString());
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->input('min_price'));
        }

        if ($request->filled('max_price') && (int) $request->input('max_price') > 0) {
            $query->where('price', '<=', (int) $request->input('max_price'));
        }

        return response()->json($query->get());
    }
}
