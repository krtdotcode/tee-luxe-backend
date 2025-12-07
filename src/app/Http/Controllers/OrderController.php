<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('orderDetails.product.category')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Store a newly created order from cart checkout.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_email' => 'required|string|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'shipping_city' => 'required|string|max:255',
            'shipping_region' => 'required|string|max:255',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:wallet,cod',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $userId = $request->user()->id;

            // Get user's cart items
            $cartItems = ShoppingCart::with('product')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $shippingCost = $subtotal > 1000 ? 0 : 149.99;
            $totalAmount = $subtotal + $shippingCost;

            // Generate unique order number
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);

            // For now, both COD and wallet result in pending payment
            // Future: wallet can be marked as paid, COD remains pending until delivery
            $paymentStatus = $validated['payment_method'] === 'wallet' ? 'paid' : 'pending';

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'shipping_first_name' => $validated['shipping_first_name'],
                'shipping_last_name' => $validated['shipping_last_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_region' => $validated['shipping_region'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
            ]);

            // Create order details and update stock
            foreach ($cartItems as $cartItem) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                    'total' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Reduce product stock
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear user's cart
            ShoppingCart::where('user_id', $userId)->delete();

            return response()->json($order->load('orderDetails.product.category'), 201);
        });
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): JsonResponse
    {
        // Ensure user owns the order
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('orderDetails.product.category'));
    }
}
