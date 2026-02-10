<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Track Your Order') }} - Maryam Cake & Cookies</title>

    <!-- Logo & Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_maryam.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">

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
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 94, 60, 0.1);
        }
    </style>
</head>

<body class="antialiased text-[#4A3728]">
    <div class="fixed top-0 left-0 right-0 z-50 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <a href="/" class="text-3xl font-serif font-bold tracking-tighter text-[#8B5E3C]">
                Maryam <span class="text-[#D4AF37]">Cake & Cookies</span>
            </a>
        </div>
    </div>

    <main class="min-h-screen flex items-center justify-center px-4 pt-20">
        <div class="w-full max-w-lg">
            <div class="premium-card rounded-[3rem] p-10 shadow-2xl overflow-hidden relative">
                <!-- Decorative pulse -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#D4AF37]/5 rounded-full blur-3xl"></div>

                <div class="relative z-10 text-center mb-10">
                    <span
                        class="text-[#D4AF37] font-bold tracking-widest uppercase text-xs">{{ __('Track Status') }}</span>
                    <h1 class="text-4xl font-serif font-bold mt-2 text-[#4A3728]">{{ __('Where is My Treat?') }}</h1>
                    <p class="text-[#6B4F3A]/70 mt-4">{{ __('Enter your order number to trace your sweet delivery.') }}
                    </p>
                </div>

                <form action="{{ route('tracking.show') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="order_number"
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Order Number') }}</label>
                        <input type="text" name="order_number" id="order_number" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 px-6 font-bold text-center uppercase tracking-widest placeholder:text-[#8B5E3C]/20"
                            placeholder="ORD-XXXXXXXXXX">
                        @error('order_number')
                            <p class="text-red-500 text-[10px] mt-2 font-bold uppercase tracking-wide text-center">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-5 gold-pill text-white rounded-2xl font-black text-lg shadow-xl shadow-[#D4AF37]/30 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ __('Trace Now') }}
                    </button>
                </form>

                <div class="mt-10 pt-8 border-t border-[#8B5E3C]/5 text-center">
                    <a href="/"
                        class="text-sm font-bold text-[#8B5E3C] hover:text-[#D4AF37] transition-colors flex items-center justify-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Back to Bakery') }}
                    </a>
                </div>
            </div>

            <p class="mt-8 text-center text-[#8B5E3C]/40 text-[10px] font-bold uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} Maryam Cake and Cookies
            </p>
        </div>
    </main>
</body>

</html>
