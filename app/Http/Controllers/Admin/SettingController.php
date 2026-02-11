<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $shippingCost = \App\Models\Setting::getValue('shipping_cost', 0);
        return view('admin.settings.index', compact('shippingCost'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        \App\Models\Setting::set('shipping_cost', $request->shipping_cost, 'Biaya ongkir default');

        return back()->with('success', 'Pengaturan biaya ongkir berhasil diperbarui.');
    }
}
