<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category');

        // For admin users, show all products; for public, show only active products with stock
        if (!auth('sanctum')->check() || !auth('sanctum')->user()->is_admin) {
            $query->where('is_active', true)->where('stock_quantity', '>', 0);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'All') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($request->category)]);
            });
        }

        // Search by name or description
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Pagination or limit for performance
        if ($request->has('limit') && is_numeric($request->limit)) {
            $products = $query->paginate((int)$request->limit);
        } else {
            $products = $query->paginate(20); // Default pagination
        }

        return response()->json($products);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|string|max:500',
                'stock_quantity' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $validated['stock_quantity'] = $validated['stock_quantity'] ?? 0;

            $product = Product::create($validated);

            if ($product) {
                return response()->json($product->load('category'), 201);
            } else {
                return response()->json(['message' => 'Failed to create product'], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Product creation failed: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('category'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        try {
            $validated = $request->validate([
                'category_id' => 'sometimes|exists:categories,id',
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|numeric|min:0',
                'image' => 'nullable|string|max:500',
                'stock_quantity' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

            if (isset($validated['stock_quantity'])) {
                $validated['stock_quantity'] = $validated['stock_quantity'] ?? 0;
            }

            $updated = $product->update($validated);

            if ($updated) {
                return response()->json($product->load('category'));
            } else {
                return response()->json(['message' => 'Failed to update product'], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Product update failed: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $deleted = $product->delete();

            if ($deleted) {
                return response()->json(['message' => 'Product deleted successfully']);
            } else {
                return response()->json(['message' => 'Failed to delete product'], 500);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Product deletion failed: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'product_name' => $product->name
            ]);

            return response()->json([
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
