<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
            'tracking_number' => 'nullable|string',
            'courier_name' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // DB Transaction for data consistency
        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $order, $oldStatus, $newStatus) {

            $order->update($request->only(['status', 'payment_status', 'tracking_number', 'courier_name', 'latitude', 'longitude']));

            // Case 1: Order Cancelled -> Restore Stock
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            // Case 2: Order Un-Cancelled (Recovered) -> Reduce Stock again
            elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    // Start checking stock if we want to be strict, but for admin override we just deduct
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Order status updated. Stock has been adjusted automatically.');
    }
}
