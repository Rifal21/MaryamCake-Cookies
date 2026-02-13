<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController; // Added this use statement

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/checkout', [LandingController::class, 'checkout'])->name('checkout');
Route::get('/order/{order_number}/invoice', [LandingController::class, 'downloadInvoice'])->name('order.invoice');

Route::get('/track', [\App\Http\Controllers\OrderTrackingController::class, 'index'])->name('tracking.index');
Route::get('/track/{order_number}', [\App\Http\Controllers\OrderTrackingController::class, 'directTrack'])->name('tracking.direct');
Route::post('/track', [\App\Http\Controllers\OrderTrackingController::class, 'show'])->name('tracking.show');
Route::get('/track/{order}/status', [\App\Http\Controllers\OrderTrackingController::class, 'getStatus'])->name('tracking.status');

// Public Stats
Route::get('/api/stats/visitors', function () {
    return response()->json([
        'visitors' => \App\Models\SiteVisit::where('last_activity_at', '>=', now()->subMinutes(5))->count()
    ]);
})->name('public.stats.visitors');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products/export', [\App\Http\Controllers\Admin\ProductController::class, 'export'])->name('products.export');
    Route::get('/products/template', [\App\Http\Controllers\Admin\ProductController::class, 'downloadTemplate'])->name('products.template');
    Route::post('/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])->name('products.import');
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    // Vouchers
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);

    // Payments
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentMethodController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Stats
    Route::get('/stats/visitors', function () {
        return response()->json([
            'visitors' => \App\Models\SiteVisit::where('last_activity_at', '>=', now()->subMinutes(5))->count()
        ]);
    })->name('stats.visitors');
});

Route::post('/vouchers/check', [LandingController::class, 'checkVoucher'])->name('vouchers.check');

require __DIR__ . '/auth.php';
