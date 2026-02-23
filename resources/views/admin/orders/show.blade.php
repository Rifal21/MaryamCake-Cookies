<x-app-layout>
    @section('header_title', __('Order Details'))

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}"
            class="inline-flex items-center text-sm font-bold text-[#8B5E3C] hover:text-[#D4AF37] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders List') }}
        </a>

        <div class="flex items-center space-x-4">
            <a href="{{ route('order.invoice', $order->order_number) }}"
                class="inline-flex items-center px-4 py-2 bg-[#8B5E3C] text-white text-xs font-bold rounded-xl hover:bg-[#6A462D] transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                {{ __('Download Invoice') }}
            </a>
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" id="delete-order-form">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDeleteOrder()"
                    class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('Delete Order') }}
                </button>
            </form>
            <div class="h-8 w-px bg-[#8B5E3C]/10 mx-2"></div>
            <div class="flex items-center space-x-3">
                <span
                    class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/50">{{ __('Order Status:') }}</span>
                <span
                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $order->status == 'shipping' ? 'bg-purple-100 text-purple-700' : '' }}
                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
            ">
                    {{ __(ucfirst($order->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 grid-flow-row-dense">
        <!-- Items Card -->
        <div class="card-premium rounded-[2rem] overflow-hidden lg:col-span-2">
            <div class="p-8 border-b border-[#8B5E3C]/5 bg-gray-50/30">
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Order Information') }} <span
                        class="text-[#D4AF37]">#{{ $order->order_number }}</span></h3>
                @if ($order->is_preorder)
                    <div class="mt-4 flex items-center gap-4 p-4 bg-orange-50 border border-orange-200 rounded-2xl">
                        <div
                            class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-white text-2xl">
                            📦
                        </div>
                        <div>
                            <span
                                class="block text-[10px] font-black uppercase tracking-widest text-orange-600/60">{{ __('Pre-Order Status') }}</span>
                            <span
                                class="block font-black text-orange-700">{{ __('Scheduled for Delivery on:') }}</span>
                            <span
                                class="text-lg font-black text-[#4A3728]">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y - H:i') }}</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="p-8">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-[10px] font-black uppercase tracking-widest text-[#8B5E3C]/50 border-b border-[#8B5E3C]/5">
                            <th class="text-left py-4">{{ __('Product') }}</th>
                            <th class="text-center py-4">{{ __('Quantity') }}</th>
                            <th class="text-right py-4">{{ __('Price') }}</th>
                            <th class="text-right py-4 pr-4">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#8B5E3C]/5">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="py-6">
                                    <div class="flex items-center">
                                        <div
                                            class="w-16 h-16 rounded-2xl overflow-hidden mr-4 shadow-sm border border-[#8B5E3C]/5 flex-shrink-0">
                                            <img src="{{ asset($item->product->image) }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-bold text-[#4A3728]">{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td class="py-6 text-center font-bold text-lg">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-6 text-right text-sm">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="py-6 text-right pr-4 font-black">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $subtotal = $order->items->sum(function ($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp
                        <tr class="bg-gray-50/10">
                            <td colspan="3"
                                class="py-4 text-right font-bold text-[#8B5E3C]/60 uppercase tracking-widest text-[10px]">
                                {{ __('Subtotal') }}</td>
                            <td class="py-4 pr-12 text-right font-bold text-[#4A3728]">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if ($order->discount_amount > 0)
                            <tr class="bg-green-50/30">
                                <td colspan="3"
                                    class="py-4 text-right font-bold text-green-600 uppercase tracking-widest text-[10px]">
                                    {{ __('Voucher') }} ({{ $order->voucher_code }})
                                </td>
                                <td class="py-4 pr-12 text-right font-bold text-green-600">
                                    - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->admin_fee > 0)
                            <tr class="bg-blue-50/10">
                                <td colspan="3"
                                    class="py-4 text-right font-bold text-[#8B5E3C] uppercase tracking-widest text-[10px]">
                                    {{ __('Admin Fee') }} ({{ $order->payment_method_name }})
                                </td>
                                <td class="py-4 pr-12 text-right font-bold text-[#8B5E3C]">
                                    + Rp {{ number_format($order->admin_fee, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        <tr class="bg-gray-50/50">
                            <td colspan="3"
                                class="py-8 pl-8 text-right font-bold text-[#8B5E3C] uppercase tracking-widest text-xs">
                                {{ __('Grand Total') }}</td>
                            <td class="py-8 pr-12 text-right">
                                <span class="text-3xl font-black text-[#D4AF37]">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Shipping/Notes Card -->
        <div class="card-premium rounded-[2rem] p-8 lg:col-span-2">
            <h3 class="text-lg font-black text-[#4A3728] mb-6 border-b pb-4">{{ __('Shipping & Instructions') }}
            </h3>
            <div class="{{ $order->latitude && $order->longitude ? 'grid md:grid-cols-2 gap-8' : '' }}">
                <div class="h-full">
                    <div class="bg-[#F8F4ED] rounded-3xl p-8 border border-[#8B5E3C]/10 h-full">
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">
                            {{ __('Customer\'s Full Address') }}</p>
                        <p class="text-[#4A3728] font-medium leading-relaxed whitespace-pre-wrap">
                            {{ $order->address }}</p>

                        @if ($order->notes)
                            <div class="mt-8 pt-8 border-t border-[#8B5E3C]/10">
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">
                                    {{ __('Special Instructions') }}</p>
                                <p class="text-[#4A3728] italic">"{{ $order->notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($order->latitude && $order->longitude)
                    <div class="h-full">
                        <div
                            class="h-full rounded-2xl overflow-hidden border border-[#8B5E3C]/20 relative z-0 flex flex-col">
                            <div id="admin-map" class="flex-1 min-h-[250px] w-full z-0"></div>
                            <div class="bg-gray-50 border-t border-[#8B5E3C]/10 p-3 flex justify-between items-center">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Delivery Location') }}</span>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}"
                                    target="_blank"
                                    class="text-xs font-bold text-[#D4AF37] hover:underline flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Customer Card -->
        <div class="card-premium rounded-[2rem] p-8 overflow-hidden relative lg:col-span-1">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-[#D4AF37]/5 rounded-full"></div>
            <h3 class="text-lg font-black text-[#4A3728] mb-6 relative z-10">{{ __('Customer Details') }}</h3>
            <div class="flex items-center mb-8 relative z-10">
                <div
                    class="w-16 h-16 rounded-[1.5rem] gold-gradient shadow-lg flex items-center justify-center text-white text-2xl font-black mr-4">
                    {{ substr($order->customer_name, 0, 1) }}
                </div>
                <div>
                    <span class="block text-xl font-bold">{{ $order->customer_name }}</span>
                    <span class="text-sm text-[#8B5E3C]/60">{{ __('Valued Customer') }}</span>
                </div>
            </div>
            <div class="space-y-4 relative z-10">
                <div class="p-4 rounded-2xl bg-gray-50 flex items-center">
                    <svg class="w-5 h-5 text-[#D4AF37] mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="font-bold text-sm">{{ $order->customer_phone }}</span>
                </div>
                @if ($order->customer_email)
                    <div class="p-4 rounded-2xl bg-gray-50 flex items-center">
                        <svg class="w-5 h-5 text-[#D4AF37] mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-bold text-sm">{{ $order->customer_email }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-8">
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->customer_phone)) }}"
                    target="_blank"
                    class="w-full flex items-center justify-center p-4 rounded-2xl bg-green-500 text-white font-bold shadow-lg shadow-green-500/20 hover:scale-[1.03] transition-all">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    {{ __('Contact User') }}
                </a>
            </div>
        </div>

        <!-- Management Card -->
        <div class="card-premium rounded-[2rem] p-8 lg:col-span-1">
            <h3 class="text-lg font-black text-[#4A3728] mb-6 border-b pb-4">{{ __('Manage Process') }}</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-6">
                @csrf @method('PATCH')
                <div class="mb-6 bg-[#FDFBF7] p-4 rounded-2xl border border-[#8B5E3C]/10">
                    <label
                        class="block text-[10px] font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-1">{{ __('Payment Method Used') }}</label>
                    <p class="font-black text-[#4A3728] text-lg">{{ $order->payment_method_name }}</p>
                </div>

                <div class="mb-6">
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Payment Status') }}</label>
                    <select name="payment_status"
                        class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold text-[#4A3728]">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                            {{ __('Unpaid') }}
                        </option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                            {{ __('Paid') }}
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Order Status') }}</label>
                    <select name="status" id="status-select"
                        class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold text-[#4A3728]">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                            {{ __('Pending') }}
                        </option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                            {{ __('Processing') }}</option>
                        <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>
                            {{ __('Shipping') }}
                        </option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                            {{ __('Completed') }}
                        </option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                            {{ __('Cancelled') }}
                        </option>
                    </select>
                </div>

                <div class="flex items-center gap-3 py-2">
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notify_wa" id="notify_wa" value="1" class="sr-only peer"
                            checked>
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#25D366]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#25D366]">
                        </div>
                        <label for="notify_wa"
                            class="ml-3 text-sm font-bold text-[#4A3728]">{{ __('Kirim Notifikasi WA ke Pelanggan') }}</label>
                    </div>
                </div>

                <div id="tracking-fields"
                    class="{{ $order->status == 'shipping' ? '' : 'hidden' }} space-y-6 border-t border-[#8B5E3C]/5 pt-6">
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#D4AF37]">
                        {{ __('Tracking Information') }}</h4>

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Tracking Number / Resi') }}</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Courier Name') }}</label>
                        <input type="text" name="courier_name" value="{{ $order->courier_name }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold"
                            placeholder="{{ __('e.g., John Doe') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Latitude') }}</label>
                            <input type="text" name="latitude" id="lat-input" value="{{ $order->latitude }}"
                                class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold text-xs">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Longitude') }}</label>
                            <input type="text" name="longitude" id="lng-input" value="{{ $order->longitude }}"
                                class="w-full rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold text-xs">
                        </div>
                    </div>

                    <button type="button" onclick="getLocation()"
                        class="w-full py-2 bg-[#8B5E3C]/10 text-[#8B5E3C] rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-[#8B5E3C]/20 transition-all flex items-center justify-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Use Current Location') }}
                    </button>
                </div>

                <button type="submit"
                    class="w-full py-4 sidebar-gradient text-white rounded-2xl font-black shadow-lg hover:scale-[1.02] transition-all">
                    {{ __('Update Process Status') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($order->latitude && $order->longitude)
                const map = L.map('admin-map').setView([{{ $order->latitude }}, {{ $order->longitude }}], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([{{ $order->latitude }}, {{ $order->longitude }}]).addTo(map)
                    .bindPopup("<b>{{ $order->customer_name }}</b><br>{{ $order->address }}")
                    .openPopup();
            @endif
        });

        document.getElementById('status-select').addEventListener('change', function() {
            const trackingFields = document.getElementById('tracking-fields');
            if (this.value === 'shipping') {
                trackingFields.classList.remove('hidden');
            } else {
                trackingFields.classList.add('hidden');
            }
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('lat-input').value = position.coords.latitude.toFixed(8);
                    document.getElementById('lng-input').value = position.coords.longitude.toFixed(8);
                }, function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Geolocation Error',
                        text: 'Error getting location: ' + error.message,
                        confirmButtonColor: '#d33'
                    });
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Not Supported',
                    text: 'Geolocation is not supported by this browser.',
                    confirmButtonColor: '#D4AF37'
                });
            }
        }

        function confirmDeleteOrder() {
            Swal.fire({
                title: '{{ __('Hapus Pesanan?') }}',
                text: '{{ __('Pesanan akan dipindahkan ke tempat sampah (Soft Delete).') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8B5E3C',
                confirmButtonText: '{{ __('Ya, Hapus!') }}',
                cancelButtonText: '{{ __('Batal') }}',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-order-form').submit();
                }
            })
        }
    </script>
</x-app-layout>
