<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LandingController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->with('category')->get();
        $categories = \App\Models\Category::all();
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        return view('welcome', compact('products', 'categories', 'paymentMethods'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'cart' => 'required|array',
            'voucher_code' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $totalPrice = 0;
                $orderNumber = 'ORD-' . strtoupper(Str::random(10));

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'address' => $request->address,
                    'total_price' => 0, // Will update after items
                    'status' => 'pending',
                    'payment_method_name' => $request->payment_method,
                ]);

                foreach ($request->cart as $item) {
                    $product = Product::findOrFail($item['id']);
                    $price = $product->price * $item['quantity'];
                    $totalPrice += $price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ]);

                    // Optional: Decrease stock
                    $product->decrement('stock', $item['quantity']);
                }

                $paymentMethodObj = \App\Models\PaymentMethod::where('name', $request->payment_method)->first();
                $adminFee = $paymentMethodObj ? $paymentMethodObj->admin_fee : 0;

                $voucher = null;
                $discountAmount = 0;

                if ($request->voucher_code) {
                    $voucher = Voucher::where('code', $request->voucher_code)->first();
                    if ($voucher && $voucher->isValid() && $totalPrice >= $voucher->min_spend) {
                        $discountAmount = $voucher->calculateDiscount($totalPrice);
                    }
                }

                $finalTotal = max(0, $totalPrice - $discountAmount + $adminFee);

                $order->update([
                    'total_price' => $finalTotal,
                    'discount_amount' => $discountAmount,
                    'admin_fee' => $adminFee,
                    'voucher_id' => $voucher?->id,
                    'voucher_code' => $voucher?->code,
                ]);

                if ($voucher) {
                    $voucher->increment('used_count');
                }

                return response()->json([
                    'success' => true,
                    'order_number' => $orderNumber,
                    'invoice_url' => route('order.invoice', $orderNumber),
                    'message' => __('Order placed successfully!')
                ]);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadInvoice($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product')->firstOrFail();
        $paymentMethod = \App\Models\PaymentMethod::where('name', $order->payment_method_name)->first();

        $pdf = Pdf::loadView('invoice.pdf', compact('order', 'paymentMethod'));

        return $pdf->stream('Invoice-' . $order->order_number . '.pdf');
    }

    public function checkVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => __('Voucher code not found.')
            ]);
        }

        if (!$voucher->isValid()) {
            return response()->json([
                'success' => false,
                'message' => __('Voucher is no longer valid or has reached its usage limit.')
            ]);
        }

        if ($request->subtotal < $voucher->min_spend) {
            return response()->json([
                'success' => false,
                'message' => __('Minimum spend for this voucher is Rp :min', ['min' => number_format($voucher->min_spend, 0, ',', '.')])
            ]);
        }

        $discount = $voucher->calculateDiscount($request->subtotal);

        return response()->json([
            'success' => true,
            'code' => $voucher->code,
            'discount' => $discount,
            'message' => __('Voucher applied successfully!')
        ]);
    }
}
