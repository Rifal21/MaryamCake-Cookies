<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Trace Order') }} #{{ $order->order_number }} - Maryam Cake & Cookies</title>

    <!-- Logo & Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_maryam.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FDFBF7;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .gold-pill {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        }

        .premium-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 94, 60, 0.1);
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 2rem;
            z-index: 10;
        }

        .status-dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
</head>

<body class="antialiased text-[#4A3728]">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-[#8B5E3C]/10 py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-serif font-bold tracking-tighter text-[#8B5E3C]">
                Maryam <span class="text-[#D4AF37]">Cake</span>
            </a>
            <a href="{{ route('tracking.index') }}"
                class="text-xs font-black uppercase tracking-widest text-[#8B5E3C] hover:text-[#D4AF37] transition-all flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                {{ __('New Trace') }}
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pt-32 pb-20">
        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Left: Order Info -->
            <div class="lg:col-span-1 space-y-8">
                <div class="premium-card rounded-[2.5rem] p-8 shadow-xl">
                    <span
                        class="text-[#D4AF37] font-bold tracking-widest uppercase text-[10px]">{{ __('Live Status') }}</span>
                    <h2 class="text-2xl font-serif font-bold mt-2 text-[#4A3728]">{{ __('Order Details') }}</h2>

                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-[#8B5E3C]/5">
                            <span
                                class="text-xs font-bold text-[#8B5E3C]/60 uppercase tracking-widest">{{ __('Order Number') }}</span>
                            <span class="font-black text-[#4A3728]">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-[#8B5E3C]/5">
                            <span
                                class="text-xs font-bold text-[#8B5E3C]/60 uppercase tracking-widest">{{ __('Status') }}</span>
                            <div class="flex items-center gap-2">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-400',
                                        'processing' => 'bg-blue-400',
                                        'shipping' => 'bg-purple-500',
                                        'completed' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500',
                                    ];
                                    $color = $statusColors[$order->status] ?? 'bg-gray-400';
                                @endphp
                                <span class="status-dot {{ $color }} animate-pulse"></span>
                                <span
                                    class="font-black uppercase text-xs tracking-widest text-[#4A3728]">{{ __(ucfirst($order->status)) }}</span>
                            </div>
                        </div>
                        @if ($order->tracking_number)
                            <div class="flex justify-between items-center pb-4 border-b border-[#8B5E3C]/5">
                                <span
                                    class="text-xs font-bold text-[#8B5E3C]/60 uppercase tracking-widest">{{ __('Tracking Number') }}</span>
                                <span class="font-black text-[#D4AF37]">{{ $order->tracking_number }}</span>
                            </div>
                        @endif
                        @if ($order->courier_name)
                            <div class="flex justify-between items-center pb-4 border-b border-[#8B5E3C]/5">
                                <span
                                    class="text-xs font-bold text-[#8B5E3C]/60 uppercase tracking-widest">{{ __('Courier Name') }}</span>
                                <span class="font-black text-[#4A3728]">{{ $order->courier_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="premium-card rounded-[2.5rem] p-8 shadow-xl">
                    <h3 class="font-bold text-[#4A3728] mb-6 uppercase tracking-widest text-xs">
                        {{ __('Items Ordered') }}</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl overflow-hidden shadow-sm flex-shrink-0 flex items-center justify-center bg-[#8B5E3C]/5 border border-[#8B5E3C]/10">
                                    @if (
                                        $item->product->image &&
                                            $item->product->image !== 'images/products/default.jpg' &&
                                            file_exists(public_path($item->product->image)))
                                        <img src="{{ asset($item->product->image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-cookie text-[#D4AF37]"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-sm text-[#4A3728] truncate">{{ __($item->product->name) }}
                                    </p>
                                    <p class="text-[10px] font-bold text-[#8B5E3C]/60">{{ $item->quantity }}x • Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 border-t border-[#8B5E3C]/10 space-y-2">
                        @php
                            $subtotal = $order->items->sum(function ($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-[#8B5E3C]/60">{{ __('Subtotal') }}</span>
                            <span class="font-bold text-[#4A3728]">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between items-center text-sm text-green-600">
                                <span class="font-bold tracking-tight">{{ __('Voucher') }}
                                    ({{ $order->voucher_code }})</span>
                                <span class="font-bold">- Rp
                                    {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if ($order->admin_fee > 0)
                            <div class="flex justify-between items-center text-sm text-[#8B5E3C]">
                                <span class="font-bold tracking-tight">{{ __('Admin Fee') }}
                                    ({{ $order->payment_method_name }})</span>
                                <span class="font-bold">+ Rp
                                    {{ number_format($order->admin_fee, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-2 border-t border-[#8B5E3C]/5">
                            <span class="font-bold text-[#4A3728] text-lg">{{ __('Total') }}</span>
                            <span class="text-2xl font-black text-[#8B5E3C]">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Map and Progress -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Map Section -->
                <div class="premium-card rounded-[3rem] p-4 shadow-2xl relative overflow-hidden">
                    <div id="map"></div>

                    @if ($order->status != 'shipping')
                        <div class="absolute inset-0 z-20 bg-white/40 backdrop-blur-[2px] flex items-center justify-center p-8 text-center"
                            id="map-overlay">
                            <div class="max-w-xs">
                                <div
                                    class="w-16 h-16 gold-gradient rounded-full mx-auto flex items-center justify-center mb-6 shadow-lg shadow-[#D4AF37]/30">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-serif font-bold text-[#4A3728] mb-2">
                                    {{ __('Preparing Your Order') }}</h4>
                                <p class="text-sm text-[#6B4F3A]">
                                    {{ __('Live tracking will be available once your treats are out for delivery.') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Delivery Address -->
                <div class="premium-card rounded-[2.5rem] p-8 shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-green-50 rounded-2xl text-green-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-1">
                                {{ __('Delivery Address') }}</h4>
                            <p class="font-bold text-[#4A3728] leading-relaxed">{{ $order->address }}</p>
                            <p class="text-xs text-[#8B5E3C]/60 mt-2">{{ $order->customer_name }} •
                                {{ $order->customer_phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="premium-card rounded-[2.5rem] p-8 shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-1">
                                {{ __('Payment Method') }}</h4>
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-black text-[#4A3728] text-lg">{{ $order->payment_method_name }}</p>
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ __(ucfirst($order->payment_status)) }}
                                </span>
                            </div>

                            @if ($order->payment_status === 'unpaid')
                                @php
                                    $paymentMethod = \App\Models\PaymentMethod::where(
                                        'name',
                                        $order->payment_method_name,
                                    )->first();
                                @endphp

                                @if ($paymentMethod)
                                    <div class="bg-gray-50 rounded-2xl p-4 mt-4 space-y-3">
                                        @if ($paymentMethod->account_number)
                                            <div>
                                                <p class="text-[10px] uppercase font-bold text-[#8B5E3C]/60">
                                                    {{ __('Transfer To') }}</p>
                                                <p class="text-sm font-black text-[#4A3728]">
                                                    {{ $paymentMethod->account_name }}</p>
                                                <p class="text-xl font-black text-[#D4AF37] tracking-tight">
                                                    {{ $paymentMethod->account_number }}</p>
                                            </div>
                                        @endif
                                        @if ($paymentMethod->instructions)
                                            <div class="pt-3 border-t border-gray-200">
                                                <p class="text-[10px] uppercase font-bold text-[#8B5E3C]/60 mb-1">
                                                    {{ __('Instructions') }}</p>
                                                <p class="text-xs text-[#6B4F3A] italic leading-relaxed">
                                                    {{ $paymentMethod->instructions }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-6">
                                        <a href="https://wa.me/6281234567890?text={{ urlencode("Halo Maryam Cake! Saya sudah membayar pesanan #{$order->order_number}. Mohon dicek ya!") }}"
                                            target="_blank"
                                            class="w-full flex items-center justify-center p-4 rounded-2xl bg-green-500 text-white font-bold shadow-lg shadow-green-500/20 hover:scale-[1.03] transition-all">
                                            <i class="fa-brands fa-whatsapp mr-2"></i>
                                            {{ __('Konfirmasi Sudah Bayar') }}
                                        </a>
                                        <p
                                            class="text-[10px] text-center mt-3 text-red-500 font-bold uppercase tracking-widest">
                                            * {{ __('Lampirkan bukti transfer di WhatsApp') }}
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="bg-green-50 rounded-2xl p-4 mt-4 flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-green-800">
                                        {{ __('Payment has been verified. Thank you!') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialLat = {{ $order->latitude ?? -6.2 }};
            const initialLng = {{ $order->longitude ?? 106.816666 }};
            const orderStatus = '{{ $order->status }}';

            const map = L.map('map').setView([initialLat, initialLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const courierIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/2972/2972185.png', // Delivery bike icon
                iconSize: [40, 40],
                iconAnchor: [20, 20],
                popupAnchor: [0, -20]
            });

            const marker = L.marker([initialLat, initialLng], {
                    icon: courierIcon
                }).addTo(map)
                .bindPopup('{{ __('Your Maryam Treats are here!') }}' + (orderStatus === 'shipping' &&
                    '{{ $order->courier_name }}' ?
                    '<br><span class="font-bold text-xs uppercase tracking-widest text-[#D4AF37]">{{ __('Courier Name') }}: {{ $order->courier_name }}</span>' :
                    ''))
                .openPopup();

            // Real-time update simulation/logic
            if (orderStatus === 'shipping') {
                setInterval(async () => {
                    try {
                        const response = await fetch('{{ route('tracking.status', $order) }}');
                        const data = await response.json();

                        if (data.latitude && data.longitude) {
                            const newPos = L.latLng(data.latitude, data.longitude);
                            marker.setLatLng(newPos);
                            map.panTo(newPos);

                            if (data.status !== orderStatus) {
                                location.reload(); // Refresh if status changed (e.g. to completed)
                            }
                        }
                    } catch (error) {
                        console.error('Error fetching position:', error);
                    }
                }, 5000); // Update every 5 seconds
            }
        });
    </script>
</body>

</html>
