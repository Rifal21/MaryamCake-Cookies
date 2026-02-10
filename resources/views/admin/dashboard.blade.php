<x-app-layout>
    @section('header_title', __('Dashboard Overview'))

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
        <div class="card-premium p-8 rounded-[2rem] relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <span
                    class="text-[#8B5E3C]/60 text-sm font-bold uppercase tracking-widest">{{ __('Total Orders') }}</span>
                <span class="text-4xl font-black mt-2">{{ $stats['total_orders'] }}</span>
                <div class="mt-4 flex items-center text-blue-600 text-sm font-bold">
                    <span>{{ __('All lifetime orders') }}</span>
                </div>
            </div>
        </div>

        <div class="card-premium p-8 rounded-[2rem] relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <span class="text-[#8B5E3C]/60 text-sm font-bold uppercase tracking-widest">{{ __('Pending') }}</span>
                <span class="text-4xl font-black mt-2 text-yellow-600">{{ $stats['pending_orders'] }}</span>
                <div class="mt-4 flex items-center text-yellow-600 text-sm font-bold">
                    <span>{{ __('Waiting to be processed') }}</span>
                </div>
            </div>
        </div>

        <div class="card-premium p-8 rounded-[2rem] relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <span class="text-[#8B5E3C]/60 text-sm font-bold uppercase tracking-widest">{{ __('Products') }}</span>
                <span class="text-4xl font-black mt-2">{{ $stats['total_products'] }}</span>
                <div class="mt-4 flex items-center text-green-600 text-sm font-bold">
                    <span>{{ __('Listed on website') }}</span>
                </div>
            </div>
        </div>

        <div class="card-premium p-8 rounded-[2rem] relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <span
                    class="text-[#8B5E3C]/60 text-sm font-bold uppercase tracking-widest">{{ __('Monthly Revenue') }}</span>
                <span class="text-3xl font-black mt-2 text-purple-600">Rp
                    {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</span>
                <div class="mt-4 flex items-center text-xs font-bold">
                    @php
                        $diff = $stats['monthly_revenue'] - $stats['last_month_revenue'];
                        $isUp = $diff >= 0;
                    @endphp
                    <span class="{{ $isUp ? 'text-green-600' : 'text-red-500' }}">
                        {{ $isUp ? '↑' : '↓' }} Rp {{ number_format(abs($diff), 0, ',', '.') }}
                    </span>
                    <span class="text-[#8B5E3C]/40 ml-2 italic">vs last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Recent Orders Table -->
        <div class="lg:col-span-2">
            <div class="card-premium rounded-[2rem] overflow-hidden">
                <div class="p-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-[#4A3728]">{{ __('Recent Orders') }}</h3>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm font-bold text-[#D4AF37] hover:underline">{{ __('View All Orders') }} &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 uppercase text-[10px] font-black tracking-widest text-[#8B5E3C]/60">
                                <th class="px-8 py-4 text-left">{{ __('Order #') }}</th>
                                <th class="px-8 py-4 text-left">{{ __('Customer') }}</th>
                                <th class="px-8 py-4 text-left">{{ __('Total') }}</th>
                                <th class="px-8 py-4 text-left">{{ __('Status') }}</th>
                                <th class="px-8 py-4 text-right pr-12">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#8B5E3C]/5">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-8 py-5">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="text-sm font-bold text-blue-600 hover:underline">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-sm font-bold block">{{ $order->customer_name }}</span>
                                        <span class="text-[10px] text-[#8B5E3C]/50">{{ $order->customer_phone }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-sm font-bold">Rp
                                            {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status == 'shipping' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right pr-12 text-[#8B5E3C]/70 text-sm">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-500 italic">No orders
                                        recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column / Tools -->
        <div class="space-y-10">
            <!-- Top Selling Products -->
            <div class="card-premium rounded-[2rem] p-8">
                <h3 class="text-lg font-black text-[#4A3728] mb-6">{{ __('Top Selling') }}</h3>
                <div class="space-y-6">
                    @forelse($topProducts as $item)
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#8B5E3C]/5 border border-[#8B5E3C]/10 flex items-center justify-center overflow-hidden">
                                @if (
                                    $item->product->image &&
                                        $item->product->image !== 'images/products/default.jpg' &&
                                        file_exists(public_path($item->product->image)))
                                    <img src="{{ asset($item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-cookie text-[#D4AF37]"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-[#4A3728] truncate">{{ $item->product->name }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#D4AF37]">
                                    {{ $item->total_sold }} {{ __('sold') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic">{{ __('No sales data yet') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card-premium rounded-[2rem] p-8">
                <h3 class="text-lg font-black text-[#4A3728] mb-6">{{ __('Quick Actions') }}</h3>
                <div class="space-y-4">
                    <a href="{{ route('admin.products.create') }}"
                        class="flex items-center p-4 rounded-2xl bg-[#D4AF37]/5 hover:bg-[#D4AF37]/10 border border-[#D4AF37]/10 transition-all group">
                        <div
                            class="w-12 h-12 rounded-xl gold-gradient flex items-center justify-center text-white mr-4 shadow-lg shadow-[#D4AF37]/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold">{{ __('Add New Product') }}</span>
                            <span class="text-xs text-[#8B5E3C]/60 italic">{{ __('Update your menu items') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.vouchers.create') }}"
                        class="flex items-center p-4 rounded-2xl bg-blue-50/50 hover:bg-blue-50 border border-blue-100 transition-all group">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold">{{ __('Create Voucher') }}</span>
                            <span class="text-xs text-blue-600/60 italic">{{ __('Start a discount promo') }}</span>
                        </div>
                    </a>
                    <a href="/" target="_blank"
                        class="flex items-center p-4 rounded-2xl bg-[#4A3728]/5 hover:bg-[#4A3728]/10 border border-[#4A3728]/10 transition-all group">
                        <div
                            class="w-12 h-12 rounded-xl sidebar-gradient flex items-center justify-center text-white mr-4 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold">{{ __('View Website') }}</span>
                            <span class="text-xs text-[#8B5E3C]/60 italic">{{ __('Check your store front') }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Shop Status -->
            <div
                class="card-premium rounded-[2rem] p-8 text-center sidebar-gradient text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <circle cx="50" cy="50" r="40" fill="white" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h4 class="font-serif italic text-xl text-[#D4AF37] mb-2">{{ __('Premium Bakery') }}</h4>
                    <p class="text-sm opacity-80 mb-6 px-4">
                        {{ __('Maintain the quality of every slice. Your bakers are ready!') }}</p>
                    <div class="h-1 bg-white/20 rounded-full mb-6">
                        <div class="h-full bg-[#D4AF37] rounded-full w-[85%]"></div>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest opacity-60">System Operational
                        100%</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
