<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $cartItems = ShoppingCart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json($cartItems);
    }

    /**
     * Store a new item in the cart.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = $request->user()->id;

        // Check if item already exists in cart
        $existingItem = ShoppingCart::where('user_id', $userId)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingItem) {
            // Update quantity if item already in cart
            $existingItem->quantity += $validated['quantity'];
            $existingItem->save();
            return response()->json($existingItem->load('product.category'));
        }

        // Create new cart item
        $cartItem = ShoppingCart::create([
            'user_id' => $userId,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity']
        ]);

        return response()->json($cartItem->load('product.category'), 201);
    }

    /**
     * Display the specified cart item.
     */
    public function show(ShoppingCart $cart): JsonResponse
    {
        // Ensure user owns the cart item
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($cart->load('product.category'));
    }

    /**
     * Update the specified cart item.
     */
    public function update(Request $request, ShoppingCart $cart): JsonResponse
    {
        // Ensure user owns the cart item
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        if ($validated['quantity'] == 0) {
            $cart->delete();
            return response()->json(['message' => 'Item removed from cart']);
        }

        $cart->update($validated);
        return response()->json($cart->load('product.category'));
    }

    /**
     * Remove the specified cart item.
     */
    public function destroy(ShoppingCart $cart): JsonResponse
    {
        // Ensure user owns the cart item
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
