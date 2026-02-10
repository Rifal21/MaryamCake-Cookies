<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function directTrack($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product'])
            ->firstOrFail();

        return view('tracking.show', compact('order'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
        ], [
            'order_number.exists' => __('Order number not found.')
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->with(['items.product'])
            ->first();

        return view('tracking.show', compact('order'));
    }

    public function getStatus(Order $order)
    {
        return response()->json([
            'status' => $order->status,
            'latitude' => $order->latitude,
            'longitude' => $order->longitude,
            'courier_name' => $order->courier_name,
        ]);
    }
}
