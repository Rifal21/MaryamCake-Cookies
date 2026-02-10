<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->get();
        return view('admin.payments.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'admin_fee' => 'required|numeric|min:0'
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $payment)
    {
        return view('admin.payments.edit', ['paymentMethod' => $payment]);
    }

    public function update(Request $request, PaymentMethod $payment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'admin_fee' => 'required|numeric|min:0'
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment method deleted successfully.');
    }
}
