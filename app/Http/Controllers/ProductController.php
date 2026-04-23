<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->with('category')
            ->get();
        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'min_threshold' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function show(Product $product): JsonResponse
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $product->load('category');
        return response()->json($product);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:0',
            'min_threshold' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();
        return response()->json(null, 204);
    }

    public function lowStock(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->lowStock()
            ->with('category')
            ->get();
        return response()->json($products);
    }
}
