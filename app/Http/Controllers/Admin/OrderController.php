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

    public function trashed()
    {
        $orders = Order::onlyTrashed()->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'))->with('mode', 'trashed');
    }

    public function show($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
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

        // Send Notification if requested
        if ($request->boolean('notify_wa')) {
            \App\Jobs\SendWhatsAppStatusNotification::dispatch($order);
        }

        return back()->with('success', 'Order status updated. Stock has been adjusted automatically.');
    }

    public function destroy($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        if ($order->trashed()) {
            $order->forceDelete();
            return redirect()->route('admin.orders.trashed')->with('success', 'Order permanently deleted.');
        }
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order soft deleted successfully.');
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();
        return redirect()->route('admin.orders.index')->with('success', 'Order restored successfully.');
    }
}
